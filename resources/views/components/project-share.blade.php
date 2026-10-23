@props(['url'])
<div x-data="{
    message: '',
    canShare: typeof navigator.share === 'function',
    async copyLink() {
        try {
            await navigator.clipboard.writeText(this.$refs.link.value);
            this.message = 'Lien du projet copié !';
        } catch (error) {
            this.$refs.link.focus();
            this.$refs.link.select();
            this.message = 'Sélectionnez et copiez le lien ci-dessous.';
        }
    },
    async shareLink() {
        try {
            await navigator.share({ url: this.$refs.link.value });
        } catch (error) {
            if (error.name !== 'AbortError') await this.copyLink();
        }
    }
}" class="mt-8 max-w-xl mx-auto">
    <p class="font-semibold mb-3">Partagez le lien de ce projet</p>
    <div class="flex flex-col sm:flex-row gap-3">
        <input x-ref="link" type="url" readonly value="{{ $url }}"
               aria-label="Lien public du projet" @click="$el.select()"
               class="w-full min-w-0 rounded-xl border-white/50 bg-white text-gray-900 px-4 py-3 text-sm">
        <button type="button" @click="copyLink()"
                class="border border-white/50 rounded-full px-6 py-3 font-semibold whitespace-nowrap hover:bg-white/10">
            Copier le lien
        </button>
    </div>
    <button type="button" x-show="canShare" x-cloak @click="shareLink()"
            class="mt-4 border border-white/50 rounded-full px-6 py-3 hover:bg-white/10">
        Partager le projet
    </button>
    <p role="status" aria-live="polite" x-text="message" class="mt-3 text-sm text-blue-100"></p>
</div>
