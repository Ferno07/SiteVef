@extends('app')

@section('content')
<style>
    .donation-section {
        background-color: #f3f4f6;
        padding: 4rem 1rem;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }
    .donation-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        max-width: 700px;
        width: 100%;
        overflow: hidden;
        padding: 3rem;
        border: 1px solid #e5e7eb;
    }
    .donation-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .donation-header h2 {
        font-size: 2.25rem;
        color: #111827;
        margin-bottom: 0.75rem;
        font-weight: 800;
        letter-spacing: -0.025em;
    }
    .donation-header p {
        color: #6b7280;
        font-size: 1.125rem;
        line-height: 1.75rem;
    }
    .amount-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    @media (min-width: 640px) {
        .amount-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .amount-option {
        position: relative;
    }
    .amount-option input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 100%;
        width: 100%;
        z-index: 10;
    }
    .amount-box {
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.5rem 0.5rem;
        text-align: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        background-color: #fff;
        position: relative;
        overflow: hidden;
    }
    .amount-option input:checked + .amount-box {
        border-color: #2563eb;
        background-color: #eff6ff;
        color: #2563eb;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
        transform: translateY(-2px);
    }
    .amount-option input:hover + .amount-box {
        border-color: #93c5fd;
    }
    .amount-value {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }
    .check-icon {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 1.25rem;
        height: 1.25rem;
        color: #2563eb;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .amount-option input:checked + .amount-box .check-icon {
        opacity: 1;
    }
    .custom-amount {
        margin-bottom: 2.5rem;
    }
    .custom-amount label {
        display: block;
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
    }
    .input-wrapper {
        position: relative;
    }
    .currency-symbol {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-weight: 500;
        font-size: 1.1rem;
    }
    .custom-input {
        width: 100%;
        padding: 1rem 1rem 1rem 2.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        font-size: 1.1rem;
        transition: all 0.2s;
        background-color: #f9fafb;
    }
    .custom-input:focus {
        outline: none;
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    .submit-btn {
        width: 100%;
        background: linear-gradient(to right, #2563eb, #1d4ed8);
        color: white;
        padding: 1.25rem;
        border: none;
        border-radius: 0.75rem;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2), 0 2px 4px -1px rgba(37, 99, 235, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    .submit-btn:hover {
        background: linear-gradient(to right, #1d4ed8, #1e40af);
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -2px rgba(37, 99, 235, 0.15);
    }
    .submit-btn:active {
        transform: translateY(0);
    }
    .secure-notice {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .alert-error {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        color: #b91c1c;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    /* Fix for missing Tailwind classes on SVGs */
    .submit-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    .secure-notice svg {
        width: 1rem;
        height: 1rem;
        color: #059669; /* Green color for the shield */
    }
    .alert-error svg {
        width: 1.25rem;
        height: 1.25rem;
    }
</style>

<div class="donation-section">
    <div class="donation-card">
        <div class="donation-header">
            <h2>Faire un don</h2>
            <p>Votre soutien nous permet de continuer nos actions. Chaque don compte.</p>
        </div>

        @if(session('error'))
            <div class="alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('donation.checkout') }}" method="POST">
            @csrf
            
            <div class="amount-grid">
                <label class="amount-option">
                    <input type="radio" name="amount" value="10">
                    <div class="amount-box">
                        <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="amount-value">10 €</span>
                    </div>
                </label>
                <label class="amount-option">
                    <input type="radio" name="amount" value="20" checked>
                    <div class="amount-box">
                        <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="amount-value">20 €</span>
                    </div>
                </label>
                <label class="amount-option">
                    <input type="radio" name="amount" value="50">
                    <div class="amount-box">
                        <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="amount-value">50 €</span>
                    </div>
                </label>
                <label class="amount-option">
                    <input type="radio" name="amount" value="100">
                    <div class="amount-box">
                        <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="amount-value">100 €</span>
                    </div>
                </label>
            </div>

            <div class="custom-amount">
                <label for="custom-amount">Ou montant libre</label>
                <div class="input-wrapper">
                    <span class="currency-symbol">€</span>
                    <input type="number" name="custom_amount" id="custom-amount" class="custom-input" placeholder="Saisissez un montant">
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <span>Procéder au paiement sécurisé</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <p class="secure-notice">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Paiement 100% sécurisé et chiffré par Stripe.
            </p>
        </form>
    </div>
</div>

<script>
    const radios = document.querySelectorAll('input[type="radio"]');
    const customInput = document.getElementById('custom-amount');

    customInput.addEventListener('focus', () => {
        radios.forEach(r => r.checked = false);
    });

    radios.forEach(r => {
        r.addEventListener('change', () => {
            customInput.value = '';
        });
    });
</script>
@endsection
