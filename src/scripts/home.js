  const _perguntas = [
    {
      texto: "Você se considera preguiçoso?",
      opcoes: [
        { texto: "SIMMMM SOU NICOLAS", pontos: { preguica: 3 } },
        { texto: "Depende do dia", pontos: { gato: 2 } },
        { texto: "Não, sou bem ativo!!!!!", pontos: { cachorro: 2, aguia: 1 } },
        { texto: "🚬segredo..", pontos: { hesse: 1 } },
      ]
    },
    {
      texto: "Qual palavra te define melhor?",
      opcoes: [
        { texto: "🪄 Hesse", pontos: { cachorro: 3 } },
        { texto: "🧠 Espertinho haha", pontos: { hesse: 3, aguia: 1 } },
        { texto: "😶 Solitário", pontos: { gato: 3 } },
        { texto: "🎭 Misterioso uiii", pontos: { lobo: 3 } },
      ]
    },
    {
      texto: "Como você age em grupo?",
      opcoes: [
        { texto: "Sou o líder nato", pontos: { lobo: 2, aguia: 1 } },
        { texto: "ô gente..", pontos: { gato: 1, hesse: 2 } },
        { texto: "Olho vesgo pra todo mundo", pontos: { cachorro: 2 } },
        { texto: "Prefiro estar sozinho", pontos: { preguica: 2, gato: 1 } },
      ]
    },
    {
      texto: "Qual ambiente te deixa mais feliz?",
      opcoes: [
        { texto: "🌳 Floresta densa", pontos: { preguica: 2, lobo: 1 } },
        { texto: "🏠 Em casa, no sofá", pontos: { gato: 3, preguica: 1 } },
        { texto: "🚻 Banheiro público", pontos: { cachorro: 2 } },
        { texto: "🌃 Na biqueira", pontos: { aguia: 3 } },
      ]
    },
    {
      texto: "O que você faz quando está com raiva?",
      opcoes: [
        { texto: "Vem pra briga que eu te capo", pontos: { lobo: 2 } },
        { texto: "Me afasto em silêncio", pontos: { gato: 2, hesse: 1 } },
        { texto: "Resolvo de forma esperta", pontos: { hesse: 3 } },
        { texto: "Simplesmente ignoro", pontos: { preguica: 3, cachorro: 1 } },
      ]
    },
  ];

  const _resultados={
    preguica:{emoji:"🦥", nome:"Preguiça", desc:"Calmo, tranquilebs e sábio. Você sabe que a vida não precisa de pressa — a contemplação é sua maior força."},
    cachorro:{emoji:"🐕", nome:"Cachorro", desc:"Leal, animado e cheio de amor para dar. As pessoas ao seu redor são a sua maior alegria."},
    gato: {emoji:"🐈", nome:"Gato", desc:"Independente e elegante. Você tem um mundo interno rico e só se abre com quem realmente merece." },
    hesse: {emoji:"🚬", nome:"Hesse", desc:"Fumaça no cachimbo. Você adora espirrar o lança e até que curte uma maratona de programação." },
    lobo: {emoji:"🐺", nome:"Lobo", desc:"Intenso e instintivo. Você lidera com presença e nunca abre mão dos seus valores e rosna grrr."},
    aguia: {emoji:"🦅", nome:"Águia", desc:"Visionário e livre. Você enxerga o que os outros não veem e voa mais alto que as expectativas SALVE O CORINTHIANS." },
  };

  let _currentQ =0;
  const _escolhas ={};

  function _renderPergunta(index){
    const body = document.getElementById('quizBody');
    const total = _perguntas.length;
    const q = _perguntas[index];
    document.getElementById('progressBar').style.width = `${(index / total) * 100}%`;
    document.getElementById('progressLabel').textContent = `Pergunta ${index + 1} de ${total}`;
    body.innerHTML = `
      <div class="question-block" id="qBlock">
        <div class="question-text">${q.texto}</div>
        <div class="options-grid">
          ${q.opcoes.map((o, j) => `
            <button class="option-btn" onclick="_sel(${index}, ${j}, this)">${o.texto}</button>
          `).join('')}
        </div>
      </div>
    `;
  }

  function _sel(qi, oi, btn) {
    document.querySelectorAll('.option-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    _escolhas[qi] = _perguntas[qi].opcoes[oi].pontos;
    setTimeout(() => {
      const block = document.getElementById('qBlock');
      if (block) block.classList.add('leaving');
      setTimeout(() => {
        _currentQ++;
        if (_currentQ < _perguntas.length) {
          _renderPergunta(_currentQ);
        } else {
          _resultado();
        }
      }, 300);
    }, 420);
  }

  function _resultado() {
    document.getElementById('quizBody').innerHTML = '';
    document.getElementById('progressBar').style.width = '100%';
    document.getElementById('progressLabel').textContent = 'Concluído!';

    const placar = {};
    Object.values(_escolhas).forEach(pts => {
      Object.entries(pts).forEach(([animal, val]) => {
        placar[animal] = (placar[animal] || 0) + val;
      });
    });

    const vencedor = Object.entries(placar).sort((a, b) => b[1] - a[1])[0][0];
    const res = _resultados[vencedor];

    const resultDiv = document.getElementById('quizResult');
    resultDiv.style.display = 'block';
    resultDiv.innerHTML = `
      <span class="result-animal">${res.emoji}</span>
      <div class="result-title">Você é um(a) ${res.nome}!</div>
      <p class="result-desc">${res.desc}</p>
      <button class="quiz-reset" onclick="_resetQuiz()">↩ Tentar novamente</button>
    `;
  }

  function _resetQuiz() {
    _currentQ = 0;
    Object.keys(_escolhas).forEach(k => delete _escolhas[k]);
    document.getElementById('quizResult').style.display = 'none';
    _renderPergunta(0);
    document.querySelector('.quiz-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  _renderPergunta(0);