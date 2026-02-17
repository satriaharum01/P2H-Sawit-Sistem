<!--===============================================================================================-->
<script src="{{ asset('/static/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('/static/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('/static/vendor/select2/select2.min.js') }}"></script>
<script>
    // ======== DOM ELEMENTS ========
    const display = document.getElementById("lcd-text");
    const engineIndicator = document.getElementById("icon-machine");
    const lineIndicator = document.getElementById("icon-power");

    // Buttons
    const stopBTN = document.getElementById("stopBTN");
    const openBTN = document.getElementById("openBTN");
    const closeBTN = document.getElementById("closeBTN");

    // Parameters & labels
    const networkParam = document.getElementById("network-status");
    const engineParam = document.getElementById("engine-status");
    const voltageParam = document.getElementById("voltage-status");
    const networkLabel = document.getElementById("network-label");
    const engineLabel = document.getElementById("engine-label");
    const voltageLabel = document.getElementById("voltage-label");

    // ======== STATE & FLAGS ========
    let index = 0;
    const totalTime = 1000;

    // Display / animation control (khusus UI)
    let isDisplayBusy = false; // mengunci semua animasi display
    let isAnimating = false; // khusus untuk animateText (ngetik)

    // System state (khusus logic)
    let isBusy = false; // mengunci saat kirim command / fetch kritis
    let isOnline = false;
    let lastOnlineState = null;
    let isEngineRunning = false;
    let lastEngineState = null;
    let isLineIN = false;
    let lastLineINState = null;

    let interval; // untuk animateText
    let dotsInterval; // untuk titik-titik (jika dipakai)

    // Text sequence saat awal boot
    let messages = ["WELCOME", "WAITING CONNECTION"];
    let msgIndex = 0;

    // ======== UI HELPERS ========
    function startBlink() {
        display.classList.add("blink");
    }

    function stopBlink() {
        display.classList.remove("blink");
    }

    function startEngine() {
        engineIndicator.classList.add("active");
        isEngineRunning = true;
    }

    function stopEngine() {
        engineIndicator.classList.remove("active");
        isEngineRunning = false;
    }

    function startLine() {
        lineIndicator.classList.add("active");
        isLineIN = true;
    }

    function stopLine() {
        lineIndicator.classList.remove("active");
        isLineIN = false;
    }

    // ======== LCD TEXT ANIMATION (TYPEWRITER) ========
    function animateText(text) {
        isDisplayBusy = true;
        isAnimating = true;

        interval = totalTime / text.length;

        if (index < text.length) {
            display.innerHTML += text[index];
            index++;
            setTimeout(() => animateText(text), interval);
        } else {
            isAnimating = false;
            startBlink();

            // tunggu sebentar sebelum lanjut ke pesan berikutnya
            setTimeout(() => nextMessage(), 1000);
        }
    }

    function nextMessage() {
        stopBlink();
        msgIndex++;

        if (msgIndex < messages.length) {
            display.innerHTML = "";
            index = 0;
            animateText(messages[msgIndex]);
        } else {
            // selesai semua pesan boot
            isDisplayBusy = false;
            startBlink();
        }
    }

    // ======== SIMPLE CLOSING DOTS (SAFE VERSION) ========
    function animateClosingDots(baseText) {
        if (isDisplayBusy) return; // jangan ganggu animasi lain

        display.innerHTML = baseText;

        // buka lagi setelah sebentar (cukup untuk visual)
        isDisplayBusy = false;

    }

    // ======== DEVICE CHECK (POLLING) ========
    async function checkDevice() {
        try {
            const deviceName = "ESP32 Actuator 1";

            const [r1, r2, r3] = await Promise.all([
                fetch(`/relay/device/check?device_name=${deviceName}`),
                fetch(`/relay/linein`),
                fetch(`/relay/engine`)
            ]);

            const data1 = await r1.json();
            const data2 = await r2.json();
            const data3 = await r3.json();

            isOnline = data1.result !== null;
            isLineIN = data2.LineIN !== 'disconnect';
            isEngineRunning = data3.engine !== 'stop';

            enableNetworkParam(data1.result, isOnline);
            enableVoltageParam(data2.voltage, isLineIN);
            enableEngineParam(data3.engine, isEngineRunning);
        } catch (err) {
            console.error("checkDevice error:", err);
        }
    }

    // ======== PARAMETER UPDATERS ========
    function enableNetworkParam(data, online) {
        if (data === null) {
            networkLabel.classList.add("error");
            networkLabel.classList.remove("active");
        } else {
            networkLabel.classList.add("active");
            networkLabel.classList.remove("error");
        }

        enableCommand(online);
        networkParam.innerHTML = data === null ? "NULL" : data + " ms";
    }

    function enableVoltageParam(data, lineIn) {
        if (data >= 4.90) {
            voltageLabel.classList.add("active");
            voltageLabel.classList.remove("error");
        } else {
            voltageLabel.classList.add("error");
            voltageLabel.classList.remove("active");
        }

        enableLineIN(lineIn);
        voltageParam.innerHTML = data + " V";
    }

    function enableEngineParam(data, running) {
        if (data !== 'stop' && running) {
            engineLabel.classList.remove("stop");
            engineLabel.classList.add("active", "icon-spin");
        } else {
            engineLabel.classList.remove("icon-spin", "active");
            engineLabel.classList.add("stop");
        }

        enableEngine(running);
        engineParam.innerHTML = data.toUpperCase();
    }

    // ======== COMMAND / STATE HANDLERS ========
    async function enableCommand(online) {
        if (online === lastOnlineState) return;
        lastOnlineState = online;

        if (online) {
            try {
                const res = await fetch(`/relay/getLastState`);
                const data = await res.json();

                if (data.command === 'run18') {
                    uploadCommand(1, 'run18', openBTN);
                } else if (data.command === 'run21') {
                    uploadCommand(2, 'run21', closeBTN);
                } else {
                    uploadCommand(0, 'off', stopBTN);
                }

                setTimeout(() => animateClosingDots(data.text), 2000);
            } catch (err) {
                console.error(err);
            }
        } else {
            if (isDisplayBusy) return;
            display.innerHTML = "";
            animateClosingDots("CONNECTION LOST");
            setTimeout(() => animateClosingDots("WAITING CONNECTION"), 2000);
        }

        console.log("Device status:", online ? "ONLINE" : "OFFLINE");
    }

    function enableEngine(running) {
        if (running === lastEngineState) return;
        lastEngineState = running;

        running ? startEngine() : stopEngine();
    }

    function enableLineIN(lineIn) {
        if (lineIn === lastLineINState) return;
        lastLineINState = lineIn;

        if (lineIn) {
            startLine();
        } else {
            uploadCommand(0, 'off', stopBTN);
            stopLine();
        }

        console.log("LineIN status:", lineIn ? "Connected" : "Disconnected");
    }

    // ======== RELAY COMMANDS ========
    async function sendRelay(relay, state, btn) {
        const res = await fetch(`/relay/getLastState`);
        const data = await res.json();
        // 1) Bersihin state aktif semua tombol dulu
        document.querySelectorAll('.round-btn').forEach(b => {
            b.classList.remove('active');
        });

        animateClosingDots("PROCESSING");

        if (!isOnline) {
            animateClosingDots("NO CONNECTION");
            setTimeout(() => animateClosingDots("WAITING CONNECTION"), 3000);
            console.log("NO CONNECTION")
            return;
        }
        if (!isLineIN) {
            animateClosingDots("AC INPUT NOT READY");
            setTimeout(() => animateClosingDots("DEVICE READY"), 3000);
            uploadCommand(0, 'off', btn);
            console.log("LINE IN ERROR")
            return;
        }


        uploadCommand(relay, state, btn);

    }

    function uploadCommand(relay, state, btn) {

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
            .then(response => {
                if (!response.ok) {
                    throw new Error("Server error");
                }
                return response.json();
            })
            .then(data => {

                btn?.classList.remove('loading');

                if (data.status === 'success') {

                    if (!isLineIN) {
                        stopBTN.classList.add('active');
                    } else {
                        btn?.classList.add('active');
                    }

                    // Pakai teks dari server kalau ada, fallback kalau kosong
                    const txt = data.text ? data.text : "OK";
                    animateClosingDots(txt);

                } else {
                    stopEngine();
                    btn?.classList.remove('active');
                    animateClosingDots("ERROR");
                }
            })
            .catch(err => {
                console.error(err);
                stopEngine();
                btn?.classList.remove('loading');
                btn?.classList.remove('active');
                animateClosingDots("FAIL REQUEST");
            });
    }

    // ======== BOOT & POLLING ========
    window.onload = function() {
        display.innerHTML = "";
        index = 0;
        msgIndex = 0;
        animateText(messages[msgIndex]);
        setInterval(() => {checkDevice();}, 2000);
    };
</script>
