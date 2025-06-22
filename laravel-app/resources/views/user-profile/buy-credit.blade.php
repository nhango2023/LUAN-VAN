@extends('user-profile.layout')
@section('profile-right')
    <link rel="stylesheet" href="{{ asset('css/user-profile/buy-credit.css') }}">
    <style>
        .quick-card {
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
            cursor: pointer;
        }

        .quick-card.selected {
            border: 2px solid #007bff;
            /* Blue border */
            border-radius: 8px;
            background-color: #f0f8ff;
        }
    </style>

    <div class="container-fluid p-0" style="max-width: 950px;">
        <div class="section-wrap">
            <div class="credits-gradient">
                <div class="subtitle">Available questions</div>
                <div class="big-credits">{{ Auth::user()->available_question }}<span
                        style="font-size:1.3rem; font-weight:400"> <span style="color:#e3e6d7;">non-expiring
                            questions </span></span></div>
            </div>
            <form action="">
                <div class="px-3 pt-2">
                    <div class="quick-cards">
                        @foreach ($plans as $plan)
                            <div class="quick-card" data-id="{{ $plan->id }}"
                                style="pointer-events: {{ $currentPlan->id_plan == $plan->id || $plan->price == 0 ? 'none' : 'auto' }}">

                                <div><strong>{{ $plan->name }}</strong></div>
                                <div class="desc">+{{ $plan->questions_limit }} questions</div>
                                <div class="desc">+{{ $plan->processes }} processes</div>
                                <div class="desc">+{{ $plan->description }} processes</div>
                                <i class="fa fa-arrow-down"></i>
                                <div class="price">{{ $plan->duration }}days/{{ $plan->price / 1000 }}K</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr style="border: none; border-top:1.5px solid #e7e8f5; margin: 0 18px 0 18px;">
                <div class="custom-topup-section">
                    <div class="custom-row mb-2">
                        <button class="custom-btn" id="btnMinus"><i class="fa fa-minus"></i></button>
                        <span class="custom-amount" id="questionAmount">0</span>
                        <span class="custom-desc">Questions</span>
                        <button class="custom-btn" id="btnPlus"><i class="fa fa-plus"></i></button>
                    </div>

                    <div class="mb-2" style="color:#ab8260;font-size:1.1rem;" id="priceDisplay">
                        ~ {{ $additionalQuestion->price }} VND
                    </div>

                    <div class="custom-slider">
                        <input type="range" min="0" max="1000" step="1" value="0"
                            class="form-control-range w-100" id="questionRange">
                    </div>
                    <button type="submit" class="paypal-btn"><i class="fab fa-paypal"></i> Buy now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll('.quick-card');
            let selectedPlanId = null;

            cards.forEach(card => {
                if (card.style.pointerEvents === 'none') return;

                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    cards.forEach(c => c.classList.remove('selected'));

                    // Add selected class to the clicked card
                    this.classList.add('selected');
                    selectedPlanId = this.getAttribute('data-id'); // Update selected plan id
                });
            });

            // Submit handler
            const form = document.querySelector('form');
            const rangeInput = document.getElementById('questionRange');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const questions = rangeInput.value;
                // const selectedPlanId = "";
                if (!selectedPlanId) {
                    selectedPlanId = "";
                }
                if (selectedPlanId === "" && questions == 0) {
                    createToastError('error', 'Vui lòng chọn kế hoạch hoặc mua thêm câu hỏi');
                    return;
                }

                // Redirect to payment URL
                const targetURL = `/profile/payment?plan_id=${selectedPlanId}&questions=${questions}`;
                window.location.href = targetURL;
            });
        });

        // Update amount and price display
        document.addEventListener("DOMContentLoaded", function() {
            const minusBtn = document.getElementById('btnMinus');
            const plusBtn = document.getElementById('btnPlus');
            const amountSpan = document.getElementById('questionAmount');
            const priceDisplay = document.getElementById('priceDisplay');
            const rangeInput = document.getElementById('questionRange');

            const unitPrice = {{ $additionalQuestion->price }}; // price per question
            const minQuestions = parseInt(rangeInput.min);
            const maxQuestions = parseInt(rangeInput.max);
            const step = parseInt(rangeInput.step);

            let currentQuestions = parseInt(amountSpan.textContent);

            function updateUI(questions) {
                currentQuestions = questions;
                amountSpan.textContent = questions;
                const vnd = questions * unitPrice;
                priceDisplay.textContent = `~ ${vnd.toLocaleString()} VND`;
                rangeInput.value = questions;
                updateRangeBackground(rangeInput, questions, minQuestions, maxQuestions);
            }

            minusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentQuestions > minQuestions) {
                    updateUI(currentQuestions - step);
                }
            });

            plusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentQuestions < maxQuestions) {
                    updateUI(currentQuestions + step);
                }
            });

            rangeInput.addEventListener('input', function() {
                updateUI(parseInt(this.value));
            });

            function updateRangeBackground(input, value, min, max) {
                const percentage = ((value - min) / (max - min)) * 100;
                input.style.background =
                    `linear-gradient(to right, #007bff 0%, #007bff ${percentage}%, #ddd ${percentage}%, #ddd 100%)`;
            }

            updateUI(currentQuestions); // Initial load
        });
    </script>
@endsection
