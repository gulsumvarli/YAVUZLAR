let mevcutSoruIndex = 0;
let toplamPuan = 0;
let sorular = JSON.parse(localStorage.getItem('sorular')) || [];

function karistir(sorular) {
    for (let i = sorular.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [sorular[i], sorular[j]] = [sorular[j], sorular[i]];
    }
    return sorular;
}

function sonrakiSoruyuGoster() {
    if (mevcutSoruIndex < sorular.length) {
        const soru = sorular[mevcutSoruIndex];
        document.getElementById('quizSoruMetni').textContent = soru.metin;
        document.getElementById('secenekA_etiketi').textContent = soru.secenekler.A;
        document.getElementById('secenekB_etiketi').textContent = soru.secenekler.B;
        document.getElementById('secenekC_etiketi').textContent = soru.secenekler.C;
        document.getElementById('secenekD_etiketi').textContent = soru.secenekler.D;
    } else {
        quizTamamlandi();
    }
}

function quizTamamlandi() {
    document.getElementById('quizPaneli').style.display = 'none';
    document.getElementById('quizSonuc').style.display = 'block';
    document.getElementById('toplamPuan').textContent = `Toplam Puan: ${toplamPuan}`;
    document.getElementById('anaSayfayaDonBtn').style.display = 'block';
}

function cevapGonder() {
    const seciliSecenek = document.querySelector('input[name="secenek"]:checked');
    if (seciliSecenek) {
        const dogruCevap = sorular[mevcutSoruIndex].dogruCevap;
        const zorluk = sorular[mevcutSoruIndex].zorluk;

        if (seciliSecenek.value === dogruCevap) {
            if (zorluk === 'kolay') {
                toplamPuan += 1;
            } else if (zorluk === 'orta') {
                toplamPuan += 2;
            } else if (zorluk === 'zor') {
                toplamPuan += 3;
            }
        }
        
        mevcutSoruIndex++;
        sonrakiSoruyuGoster();
    } else {
        alert("Yanlış Doğruyu Götürmüyor Sallamak Bedava :)");
    }
}

document.addEventListener('DOMContentLoaded', () => {
    sorular = karistir(sorular);

    document.getElementById('cevapGonderBtn').addEventListener('click', cevapGonder);
    document.getElementById('anaSayfayaDonBtn').addEventListener('click', () => {
        window.location.href = 'index.html';
    });
    sonrakiSoruyuGoster();
});
