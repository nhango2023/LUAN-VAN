@extends('user-profile.layout')
@section('content')
    <style>
        .credits-gradient {
            background: linear-gradient(100deg, #518261 10%, #f0ddab 90%);
            color: #fff;
            border-top-right-radius: 24px;
            border-top-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            padding: 32px 32px 24px 32px;
            min-height: 125px;
            position: relative;
        }

        .rounded-top-right-lg {
            border-top-right-radius: 24px !important;
        }

        .big-credits {
            font-size: 2.6rem;
            font-weight: 600;
        }

        .subtitle {
            font-size: 1.1rem;
            letter-spacing: 0.01em;
            color: #e1fff8;
        }

        .section-wrap {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 3px 12px rgba(48, 68, 44, 0.10);
            overflow: hidden;
        }

        /* Quick top up carousel */
        .quick-cards {
            display: flex;
            overflow-x: auto;
            gap: 18px;
            padding: 10px 10px 16px 10px;
            margin-bottom: 10px;
            scroll-behavior: smooth;
        }

        .quick-card {
            flex: 0 0 180px;
            background: #f6fafd;
            border-radius: 18px;
            box-shadow: 0 1px 4px rgba(48, 68, 44, 0.04);
            padding: 22px 0 14px 0;
            text-align: center;
            min-width: 150px;
            border: 1px solid #e2eaf0;
        }

        .quick-card strong {
            font-size: 1.3rem;
            color: #518261;
            font-weight: 600;
        }

        .quick-card .desc {
            color: #8c9093;
            font-size: 0.94rem;
        }

        .quick-card .fa-arrow-down {
            color: #bcc0c2;
            margin: 8px 0;
            font-size: 1.15rem;
        }

        .quick-card .price {
            font-size: 1.1rem;
            color: #5f5d5d;
            margin-top: 1px;
        }

        /* Custom top up */
        .custom-topup-section {
            padding: 32px 8px 8px 8px;
            background: none;
            text-align: center;
        }

        .custom-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            font-size: 2rem;
        }

        .custom-btn {
            width: 40px;
            height: 40px;
            background: #5b7e57;
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            outline: none;
        }

        .custom-amount {
            font-size: 2.2rem;
            font-weight: 700;
            color: #70461b;
            margin: 0 8px;
            letter-spacing: 0.01em;
        }

        .custom-desc {
            font-size: 1.1rem;
            color: #ab8260;
            margin-left: 8px;
        }

        .custom-slider {
            width: 65%;
            margin: 24px auto 10px auto;
        }

        .paypal-btn {
            background: #ffe178;
            color: #1a1a1a;
            border: none;
            border-radius: 7px;
            font-weight: 600;
            font-size: 1.08rem;
            padding: 10px 0;
            width: 260px;
            margin: 20px auto 16px auto;
            box-shadow: 0 1px 3px rgba(44, 44, 44, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .paypal-btn i {
            color: #2a3076;
            margin-right: 6px;
            font-size: 1.3rem;
        }

        .explain-note {
            color: #969876;
            font-size: 0.98rem;
            margin-top: 14px;
        }

        @media (max-width: 768px) {
            .section-wrap {
                border-radius: 12px;
            }

            .credits-gradient {
                padding: 20px 12px 18px 12px;
            }

            .quick-cards {
                gap: 10px;
            }

            .quick-card {
                min-width: 120px;
                padding: 16px 0 6px 0;
            }

            .paypal-btn {
                width: 98%;
                font-size: 1rem;
            }

            .custom-topup-section {
                padding: 20px 0 0 0;
            }

            .custom-row {
                font-size: 1.3rem;
            }

            .custom-amount {
                font-size: 1.4rem;
            }

            .custom-slider {
                width: 95%;
            }
        }

        .account-settings-root {
            padding: 0px;
            border: none;
            background: #f8fafc;
        }
    </style>
    <div class="container-fluid p-0" style="max-width: 950px;">
        <div class="section-wrap">
            <div class="credits-gradient">
                <div class="subtitle">Available credits</div>
                <div class="big-credits">694 <span style="font-size:1.3rem; font-weight:400"> <span
                            style="color:#e3e6d7;">non-expiring credits</span></span></div>
            </div>
            <div class="px-3 pt-2 pb-4">
                <h5 class="font-weight-semibold mt-3 mb-2" style="color:#6d7c67;font-size:1.17rem">Quick top up</h5>
                <div class="quick-cards">
                    <div class="quick-card">
                        <div><strong>+ 200K</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">8$</div>
                    </div>
                    <div class="quick-card">
                        <div><strong>+ 400K</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">16$</div>
                    </div>
                    <div class="quick-card">
                        <div><strong>+ 1M</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">40$</div>
                    </div>
                    <div class="quick-card">
                        <div><strong>+ 1.4M</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">56$</div>
                    </div>
                    <div class="quick-card">
                        <div><strong>+ 2M</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">80$</div>
                    </div>
                    <div class="quick-card">
                        <div><strong>+ 3M</strong></div>
                        <div class="desc">non-expiring<br>credits</div>
                        <i class="fa fa-arrow-down"></i>
                        <div class="price">120$</div>
                    </div>
                </div>
            </div>
            <hr style="border: none; border-top:1.5px solid #e7e8f5; margin: 0 18px 0 18px;">
            <div class="custom-topup-section">
                <div class="text-left mb-3" style="color:#439071;font-weight:500;font-size:1.15rem;margin-left:12%;">
                    Custom top up</div>
                <div class="custom-row mb-2">
                    <button class="custom-btn"><i class="fa fa-minus"></i></button>
                    <span class="custom-amount">200K</span>
                    <span class="custom-desc">non-expiring credits</span>
                    <button class="custom-btn"><i class="fa fa-plus"></i></button>
                </div>
                <div class="mb-2" style="color:#ab8260;font-size:1.1rem;">~ 8 $</div>
                <div class="custom-slider">
                    <input type="range" min="100000" max="1000000" step="100000" value="200000"
                        class="form-control-range w-100">
                </div>
                <button class="paypal-btn"><i class="fab fa-paypal"></i> Top up now</button>
                <div class="explain-note mx-2">
                    <i class="fa fa-info-circle"></i>
                    1,000 credits = 1,000 characters with High Quality Voice
                    (500 characters with HD Quality Voice, 1,000 characters with High Quality Plus Voice)
                </div>
            </div>
        </div>
    </div>
@endsection
