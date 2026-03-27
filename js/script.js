document.addEventListener('DOMContentLoaded', () => {
    const browseBtn = document.getElementById('browseBtn');
    const programmesSection = document.getElementById('programmes');
    const hero = document.getElementById('hero');
    const topBtn = document.getElementById('topBtn');
    const levelFilter = document.getElementById('levelFilter');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const cards = document.querySelectorAll('.programme-card');
    const liveRegion = document.getElementById('aria-live-region');

    browseBtn?.addEventListener('click', () => {
        hero.classList.add('hidden');
        programmesSection.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.onscroll = () => {
        topBtn.style.display = (document.documentElement.scrollTop > 200) ? 'block' : 'none';
    };
    topBtn?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    const filterProgrammes = () => {
        const level = levelFilter.value;
        const keyword = searchInput.value.toLowerCase();
        let visibleCount = 0;
        cards.forEach(card => {
            const matchLevel = (level === "All") || (card.dataset.level === level);
            const matchKeyword = card.dataset.name.includes(keyword);
            card.style.display = (matchLevel && matchKeyword) ? 'block' : 'none';
            if(matchLevel && matchKeyword) visibleCount++;
        });
        liveRegion.textContent = visibleCount + " programme(s) visible";
    };

    levelFilter?.addEventListener('change', filterProgrammes);
    searchInput?.addEventListener('input', filterProgrammes);
    searchBtn?.addEventListener('click', filterProgrammes);
});