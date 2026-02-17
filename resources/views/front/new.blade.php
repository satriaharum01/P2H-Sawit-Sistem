@extends('template.app')

@section('content')
    <div class="center-wrapper">
        <div class="device-frame">
            <div class="device-panel">

                <div class="panel-header mb-3 mt-2">
                    <div class="panel-icons float-right">
                        <!-- icon mesin -->
                        <i id="icon-machine" class="fas fa-cogs"></i>
                        <!-- icon listrik -->
                        <i id="icon-power" class="fas fa-bolt"></i>
                    </div>
                    <div class="panel-title text-warning">ACTUATOR CONTROL PANEL</div>

                </div>

                <div class="lcd-display mb-3">
                    <span id="lcd-text"></span>
                </div>
                <div class="d-flex justify-content-between mx-2">
                    {{-- Status Engine --}}
                    <div class="param-box col-md-3 col-3">
                        <div id="network-label" class="label"><i class="fas fa-2x fa-wifi"></i></div>
                        <div class="value" id="network-status">. . .</div>
                    </div>

                    <div class="param-box col-md-3 col-3">
                        <div id="engine-label" class="label "><i class="fas fa-2x fa-rotate"></i></div>
                        <div class="value" id="engine-status">. . .</div>
                    </div>

                    {{-- Alternator --}}
                    <div class="param-box col-md-3 col-3">
                        <div id="voltage-label" class="label "><i class="fas fa-2x fa-gauge"></i></div>
                        <div class="value" id="voltage-status">. . .</div>
                    </div>
                </div>
                <!-- BUTTON CONTROL -->
                <div class="row text-center mt-3 justify-content-center">
                    <div class="col-4 d-flex flex-column align-items-center">
                        <div class="btn-label">UP</div>
                        <div id="openBTN" class="round-btn" onclick="sendRelay(1, 'run18',this)">▲</div>
                    </div>

                    <div class="col-4 d-flex flex-column align-items-center">
                        <div class="btn-label">STOP</div>
                        <div id="stopBTN" class="round-btn stop" onclick="sendRelay(0, 'off',this)">■</div>
                    </div>

                    <div class="col-4 d-flex flex-column align-items-center">
                        <div class="btn-label">DOWN</div>
                        <div id="closeBTN" class="round-btn" onclick="sendRelay(2, 'run21',this)">▼</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
