<script>
(function () {
    var dataEl = document.getElementById('demam-data');
    var usiaEl = document.getElementById('usia');
    if (!dataEl || !usiaEl) return;

    var cfg = JSON.parse(dataEl.textContent || '{}');
    var labelMap = {};
    var i;

    for (i = 0; i < cfg.keys.length; i++) {
        var k = cfg.keys[i];
        labelMap[cfg.label[k]] = k;
    }

    function grupFromUsia(usia) {
        return usia <= 17 ? 'anak' : 'dewasa';
    }

    function grupLabel(grup) {
        return grup === 'anak'
            ? 'Anak-Anak (0–17 tahun)'
            : 'Dewasa (> 18 tahun)';
    }

    function rentang(grup, labelVal) {
        var key = labelMap[labelVal];
        if (!key) return '';
        var map = grup === 'anak' ? cfg.anak : cfg.dewasa;
        return map[key] || '';
    }

    function syncHint(selectId) {
        var sel = document.getElementById(selectId);
        var hint = document.getElementById(selectId + '-hint');
        if (!sel || !hint) return;

        var usia = parseInt(usiaEl.value, 10);
        if (!usia || usia < 1) {
            hint.textContent = '';
            return;
        }

        var range = rentang(grupFromUsia(usia), sel.value);
        hint.textContent = sel.value && range
            ? 'Rentang suhu: ' + range
            : '';
    }

    function syncRefList() {
        var list = document.getElementById('demam-ref-list');
        if (!list) return;

        var usia = parseInt(usiaEl.value, 10);
        list.innerHTML = '';

        if (!usia || usia < 1) {
            list.innerHTML = '<li class="text-slate-500">Isi usia untuk melihat referensi.</li>';
            return;
        }

        var grup = grupFromUsia(usia);
        var map = grup === 'anak' ? cfg.anak : cfg.dewasa;
        var j;

        for (j = 0; j < cfg.keys.length; j++) {
            var key = cfg.keys[j];
            var li = document.createElement('li');
            li.innerHTML = '<span class="font-medium">' + cfg.label[key]
                + ':</span> ' + map[key];
            list.appendChild(li);
        }
    }

    function syncKelompok() {
        var lbl = document.getElementById('kelompok-usia-label');
        if (!lbl) return;

        var usia = parseInt(usiaEl.value, 10);
        lbl.textContent = (!usia || usia < 1)
            ? 'Isi usia terlebih dahulu'
            : grupLabel(grupFromUsia(usia));
    }

    function syncAll() {
        syncKelompok();
        syncRefList();
        syncHint('demam_pagi');
        syncHint('demam_sore');
    }

    usiaEl.addEventListener('input', syncAll);
    document.addEventListener('change', function (e) {
        var t = e.target;
        if (!t || !t.classList.contains('demam-select')) return;
        syncHint(t.id);
    });

    syncAll();
})();
</script>
