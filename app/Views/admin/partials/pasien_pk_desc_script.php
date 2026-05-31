<script>
(function () {
    function syncPkDesc() {
        var wrap = document.getElementById('pk-desc-wrap');
        var desc = document.getElementById('penurunan_kesadaran_deskripsi');
        var yes = document.querySelector('input[name="penurunan_kesadaran"][value="1"]');
        if (!wrap || !desc || !yes) return;

        var show = !!yes.checked;
        wrap.style.display = show ? '' : 'none';
        if (!show) desc.value = '';
    }

    document.addEventListener('change', function (e) {
        var t = e.target;
        if (!t || t.name !== 'penurunan_kesadaran') return;
        syncPkDesc();
    });

    syncPkDesc();
})();
</script>
