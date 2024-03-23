function modalGantiStatus(title, peringatan, link) {
    const titleModalGantiStatus = document.getElementById(
        "titleModalGantiStatus"
    );
    const linkGantiStatus = document.getElementById("linkGantiStatus");

    linkGantiStatus.setAttribute("href", link);
    titleModalGantiStatus.textContent = title;

    ketStatus.textContent = peringatan;
}
