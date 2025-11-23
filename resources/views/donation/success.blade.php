@extends('app')

@section('content')
<style>
    .success-section {
        background-color: #f3f4f6;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        font-family: 'Inter', sans-serif;
    }
    .success-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        max-width: 500px;
        width: 100%;
        padding: 3rem 2rem;
        text-align: center;
        border: 1px solid #e5e7eb;
    }
    .icon-container {
        width: 5rem;
        height: 5rem;
        background-color: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem auto;
    }
    .icon-container svg {
        width: 3rem;
        height: 3rem;
        color: #16a34a;
    }
    .success-title {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
    }
    .success-message {
        color: #6b7280;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }
    .home-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #2563eb;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }
    .home-btn:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }
</style>

<div class="success-section">
    <div class="success-card">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1 class="success-title">Merci infiniment !</h1>
        
        <p class="success-message">
            Votre don a bien été reçu. Grâce à votre générosité, nous pouvons continuer à mener nos actions et à aider ceux qui en ont besoin.
        </p>

        <a href="{{ route('index') }}" class="home-btn">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection
