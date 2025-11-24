@extends('app')

@section('content')

<main class="bg-gray-50 min-h-screen flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-8 sm:p-12 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-4">Faire un don</h2>
            <p class="text-lg text-gray-600">
                Votre soutien nous permet de continuer nos actions. Chaque don compte.
            </p>
        </div>

        @if(session('error'))
            <div class="rounded-md bg-red-50 p-4 border border-red-200 flex items-center gap-3">
                <svg class="h-5 w-5 text-red-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('donation.checkout') }}" method="POST" class="mt-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach([10, 20, 50, 100] as $amount)
                <label class="relative cursor-pointer group">
                    <input type="radio" name="amount" value="{{ $amount }}" {{ $amount == 20 ? 'checked' : '' }} class="peer sr-only">
                    <div class="w-full py-4 px-2 text-center rounded-xl border-2 border-gray-200 bg-white text-gray-900 font-bold text-xl transition-all peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-600 peer-hover:border-blue-300 shadow-sm hover:shadow-md">
                        {{ $amount }} €
                        <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity text-blue-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            <div>
                <label for="custom-amount" class="block text-sm font-medium text-gray-700 mb-2">Ou montant libre</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-lg">€</span>
                    </div>
                    <input type="number" name="custom_amount" id="custom-amount" class="block w-full rounded-lg border-0 py-3 pl-8 pr-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-lg sm:leading-6 bg-gray-50 focus:bg-white transition-colors" placeholder="Saisissez un montant">
                </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-3 rounded-xl bg-blue-600 px-8 py-4 text-base font-bold text-white shadow-lg hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all transform hover:scale-[1.02] hover:shadow-blue-500/30">
                <span>Procéder au paiement sécurisé</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </button>
            
            <p class="text-center text-sm text-gray-500 flex items-center justify-center gap-2">
                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Paiement 100% sécurisé et chiffré par Stripe.
            </p>
        </form>
    </div>
</main>

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
