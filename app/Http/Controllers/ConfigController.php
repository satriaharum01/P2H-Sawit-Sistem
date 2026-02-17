<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Run;

class ConfigController extends Controller
{
    public function getConfigLineIN()
    {

        $data = Config::select('*')->where('name', 'linein')->first();
        $volt = Config::select('*')->where('name', 'voltage')->first();

        // Di sini nanti ESP32 baca response ini
        return response()->json([
            'status' => 'success',
            'LineIN' => $data->value,
            'voltage' => number_format(floatval($volt->value), 2)
        ]);
    }

    public function getConfigEngine()
    {

        $data = Config::select('*')->where('name', 'engine')->first();

        // Di sini nanti ESP32 baca response ini
        return response()->json([
            'status' => 'success',
            'engine' => $data->value,
        ]);
    }

    public function getLastState()
    {
        $data = Run::select('command')->first();
        $command = $data->command;

        if ($command == 'run18') {
            $text = 'OPEN STATE';
        } elseif ($command == 'run21') {
            $text = 'CLOSE STATE';
        } elseif ($command == 'OFF') {
            $text = 'DEVICE READY';
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Relay tidak valid',
                'text' => 'INVALID STATE'
            ], 400);
        }
        // Di sini nanti ESP32 baca response ini
        return response()->json([
            'status' => 'success',
            'command' => $command,
            'text' => $text,
        ]);
    }

    // API bebas akses (untuk ESP32)
    public function configUpdate(Request $request)
    {
        $status = $request->input('status');


        // 👉 UPDATE BARIS PERTAMA SAJA (id = 1)
        $data = Config::select('*')->where('name', 'linein')->first();

        if (!$data) {
            // fallback kalau belum ada baris
            $data = Config::create(['name' => 'linein', 'value' => 'disconnect']);
        } else {
            $data->update(['value' => $status]);
        }

        return response()->json([
            'status' => 'success',
            'command' => $status,
            'id' => $data->id
        ]);
    }

    /**
     * Cek status device via ping (GET)
     */
    public function checkDevice(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string',
        ]);

        $deviceName = $request->input('device_name');

        // Ambil IP device dari DB
        $config = Config::where('name', 'deviceName')->first();
        $ip_address = Config::where('name', 'deviceIP')->first();

        if (!$config->value || !$ip_address->value) {
            return response()->json([
                'status' => 'offline',
                'result' => null,
                'message' => 'Device not registered or IP unknown',
            ]);
        }

        $ip = $ip_address->value;

        $pingTime = null; // default null
        $os = strtoupper(substr(PHP_OS, 0, 3));
        $isOnline = false;

        // Ping via shell_exec, 1 paket
        if ($os === 'WIN') {
            // Windows: ping 1 paket, timeout 1 detik
            exec("ping -n 1 -w 1000 $ip", $output, $status);
            if ($status === 0) {
                $isOnline = true;
                // ambil time=XXms
                foreach ($output as $line) {
                    if (preg_match('/time[=<]\s*(\d+)ms/i', $line, $matches)) {
                        $pingTime = (int)$matches[1];
                        break;
                    }
                }
            }
        } else {
            // Linux / Mac: ping 1 paket, timeout 1 detik
            exec("ping -c 1 -W 1 $ip", $output, $status);
            if ($status === 0) {
                $isOnline = true;
                // ambil time=XX ms
                foreach ($output as $line) {
                    if (preg_match('/time[=<]\s*(\d+(?:\.\d+)?)\s*ms/i', $line, $matches)) {
                        $pingTime = round((float)$matches[1]);
                        break;
                    }
                }
            }
        }

        if ($pingTime == null) {
            $voltageState = Config::select('*')->where('name', 'voltage')->first();
            $voltageState->value = 0;

            $lineINState = Config::select('*')->where('name', 'linein')->first();
            $lineINState->value = 'disconnect';
            if ($voltageState->isDirty()) {
                $voltageState->save();   // cuma update kalau ada perubahan
            }
            if ($lineINState->isDirty()) {
                $lineINState->save();   // cuma update kalau ada perubahan
            }
        }
        return response()->json([
            'device_name' => $deviceName,
            'ip_address' => $ip,
            'result' => $pingTime,
            'status' => $isOnline ? 'online' : 'offline',
        ]);
    }
}
