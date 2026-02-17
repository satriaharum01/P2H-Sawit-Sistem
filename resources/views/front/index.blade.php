<!DOCTYPE html>
<html>

<head>
    <title>Kontrol 2 Relay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('template.css')
    @yield('css')
    <style>
        body {
            font-family: Arial;
            text-align: center;
        }

        .box {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            display: inline-block;
        }

        .on {
            background: green;
            color: white;
            padding: 10px;
            text-decoration: none;
        }

        .off {
            background: red;
            color: white;
            padding: 10px;
            text-decoration: none;
        }

        .msg {
            margin: 10px;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            color: #333;
        }

        h2 {
            text-align: center;
            margin: 16px 0;
            font-size: 1.4rem;
        }

        .container {
            max-width: 420px;
            margin: auto;
            padding: 12px;
        }

        .status {
            text-align: center;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .relay-box {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .relay-box h3 {
            text-align: center;
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        .btn-group {
            display: flex;
            gap: 12px;
        }

        button {
            flex: 1;
            border: none;
            padding: 14px 0;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        button:active {
            transform: scale(0.97);
        }

        .btn-on {
            background: #2ecc71;
            color: #fff;
        }

        .btn-off {
            background: #e74c3c;
            color: #fff;
        }

        .msg {
            text-align: center;
            margin-top: 12px;
            font-size: 0.95rem;
        }

        /* Desktop kecil ke atas */
        @media (min-width: 600px) {
            .container {
                max-width: 520px;
            }

            h2 {
                font-size: 1.6rem;
            }

            button {
                font-size: 1.05rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Kontrol 2 Relay</h2>

        @if (session('success'))
            <p class="msg" style="color:green">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="msg" style="color:red">{{ session('error') }}</p>
        @endif

        <p style="display: none;">Perintah terakhir: <b id="lastCommand">{{ $last->command ?? '-' }}</b></p>

        <div class="relay-box">
            <h3>Relay 1</h3>
            <div class="btn-group">
                <button onclick="sendRelay(1, 'on')" class="on">ON</button>
                <button onclick="sendRelay(1, 'off')" class="off">OFF</button>
            </div>
        </div>

        <div class="relay-box">
            <h3>Relay 2</h3>
            <div class="btn-group">
                <button onclick="sendRelay(2, 'on')" class="on">ON</button>
                <button onclick="sendRelay(2, 'off')" class="off">OFF</button>
            </div>
        </div>

        <p id="statusMsg" class="msg"></p>
    </div>
</body>

@yield('js')
@include('template.js')

<script>

    function sendRelay(relay, state) {

        fetch('/relay/setState', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    relay: relay,
                    state: state
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('statusMsg').innerText = "Perintah dikirim: " + data.command;

                    // Update tampilan perintah terakhir
                    document.getElementById('lastCommand').innerText = data.command;
                } else {
                    document.getElementById('statusMsg').innerText =
                        "Error: " + data.message;
                }
            })
            .catch(err => {
                document.getElementById('statusMsg').innerText =
                    "Gagal kirim: " + err;
            });
    }
</script>

</html>
