document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('soruListeleBtn').addEventListener('click', sorulariGoster);
    document.getElementById('soruEkleBtn').addEventListener('click', () => {
        document.getElementById('soruEklemePaneli').style.display = 'block';
    });
    document.getElementById('soruFormu').addEventListener('submit', soruEkle);
    document.getElementById('quizBaslatBtn').addEventListener('click', quizBaslat);
});

function soruEkle(e) {
    e.preventDefault();

    const soruMetni = document.getElementById('soruMetni').value;
    const secenekA = document.getElementById('secenekA').value;
    const secenekB = document.getElementById('secenekB').value;
    const secenekC = document.getElementById('secenekC').value;
    const secenekD = document.getElementById('secenekD').value;
    const soruZorlugu = document.getElementById('soruZorlugu').value;

    let sorular = JSON.parse(localStorage.getItem('sorular')) || [];

    const yeniSoru = {
        id: Date.now(),
        metin: soruMetni,
        secenekler: {A: secenekA, B: secenekB, C: secenekC, D: secenekD},
        zorluk: soruZorlugu,
        dogruCevap: 'A'  
    };

    sorular.push(yeniSoru);
    localStorage.setItem('sorular', JSON.stringify(sorular));

    sorulariGoster();

    document.getElementById('soruFormu').reset();
    document.getElementById('soruEklemePaneli').style.display = 'none';
}

function sorulariGoster() {
    const soruListesi = document.getElementById('soruListesi');
    soruListesi.innerHTML = '';

    const sorular = JSON.parse(localStorage.getItem('sorular')) || [];

    sorular.forEach(soru => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${soru.metin} - ${soru.zorluk}</span>
            <div>                <button onclick="soruDuzenle(${soru.id})">Düzenle</button>
                <button onclick="soruSil(${soru.id})">Sil</button>
            </div>
        `;
        soruListesi.appendChild(li);
    });
}

function soruSil(soruId) {
    let sorular = JSON.parse(localStorage.getItem('sorular')) || [];
    sorular = sorular.filter(soru => soru.id !== soruId);
    localStorage.setItem('sorular', JSON.stringify(sorular));
    sorulariGoster();
}

function soruDuzenle(soruId) {
    let sorular = JSON.parse(localStorage.getItem('sorular')) || [];
    const soru = sorular.find(soru => soru.id === soruId);

    if (soru) {
        document.getElementById('soruMetni').value = soru.metin;
        document.getElementById('secenekA').value = soru.secenekler.A;
        document.getElementById('secenekB').value = soru.secenekler.B;
        document.getElementById('secenekC').value = soru.secenekler.C;
        document.getElementById('secenekD').value = soru.secenekler.D;
        document.getElementById('soruZorlugu').value = soru.zorluk;

        sorular = sorular.filter(soru => soru.id !== soruId);
        localStorage.setItem('sorular', JSON.stringify(sorular));

        document.getElementById('soruEklemePaneli').style.display = 'block';
    }
}

function sorulariAra() {
    const aramaDegeri = document.getElementById('aramaGirdisi').value.toLowerCase();
    const sorular = JSON.parse(localStorage.getItem('sorular')) || [];
    const filtrelenmisSorular = sorular.filter(soru => 
        soru.metin.toLowerCase().includes(aramaDegeri) ||
        soru.zorluk.toLowerCase().includes(aramaDegeri)
    );

    const soruListesi = document.getElementById('soruListesi');
    soruListesi.innerHTML = '';

    filtrelenmisSorular.forEach(soru => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${soru.metin} - ${soru.zorluk}</span>
            <div>
                <button onclick="soruDuzenle(${soru.id})">Düzenle</button>
                <button onclick="soruSil(${soru.id})">Sil</button>
            </div>
        `;
        soruListesi.appendChild(li);
    });
}

function quizBaslat() {
    window.location.href = 'Quiz.html';
}

