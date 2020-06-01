/*function changeTab() {
    let tabLinks = document.querySelectorAll(".tabs a");
    let tabPanels = document.querySelectorAll(".tabs-panel");
    for (let el of tabLinks) {
        el.addEventListener("click", e => {
            e.preventDefault();
            document.querySelector(".tabs li.active").classList.remove("active");
            document.querySelector(".tabs-panel.active").classList.remove("active");

            let parentListItem = el.parentElement;
            parentListItem.classList.add("active");
            let index = [...parentListItem.parentElement.children].indexOf(parentListItem);

            let panel = [...tabPanels].filter(el => el.getAttribute("data-index") == index);
            panel[0].classList.add("active");
        });
    }
}*/


window.addEventListener('scroll', scrollHandler, { passive: false });
window.addEventListener('touchmove', scrollHandler, { passive: false });
window.addEventListener('mousewheel', scrollHandler, { passive: false });
function scrollHandler(e) {
    if (!articles.breaks){
        let loadingClass = document.querySelector(".loading");
        let tp = window.pageYOffset + loadingClass.getBoundingClientRect().top;
        let wp = window.pageYOffset + document.documentElement.clientHeight;
        if (tp < wp) {
            e.preventDefault();
            e.stopPropagation();
            articles.getNextPage();
            return false;
        }
    }
}
