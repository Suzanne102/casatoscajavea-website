import sublinks from "./data.js";

const toggleBtn = document.querySelector(".toggle-btn");
const closeBtn = document.querySelector(".close-btn");
const sidebarWrapper = document.querySelector(".sidebar-wrapper");
const sidebar = document.querySelector(".sidebar-links");
const linkBtns = [...document.querySelectorAll(".link-btn")];
const submenu = document.querySelector(".submenu");
const hero = document.querySelector(".hero");
const nav = document.querySelector(".nav");

toggleBtn.addEventListener("click", () => {
  sidebarWrapper.classList.add("show");
});
closeBtn.addEventListener("click", () => {
  sidebarWrapper.classList.remove("show");
});

sidebar.innerHTML = sublinks
  .map((item) => {
    const { links, page } = item;

    return `
  <article>
  <h4>${page}</h4>
  <div class="sidebar-sublinks">
  ${links
    .map(({ url, icon, label }) => {
      return `<a href="${url}"><i class="${icon}"></i>${label}</a>`;
    })
    .join("")}
  </div>
  </article>`;
  })
  .join("");

linkBtns.forEach((btn) => {
  btn.addEventListener("mouseover", function (e) {
    const text = e.currentTarget.textContent;
    const tempBtn = e.currentTarget.getBoundingClientRect();
    const bottom = tempBtn.bottom - 3;
    const center = (tempBtn.left + tempBtn.right) / 2;

    const tempPage = sublinks.find(({ page }) => page === text);
    const { page, links } = tempPage;
    if (tempBtn) {
      submenu.classList.add("show");
      submenu.style.left = `${center}px`;
      submenu.style.top = `${bottom}px`;
      submenu.innerHTML = `
      <section>
      <h4>${page}</h4>
      <div class="submenu-center col-2">
      ${links
        .map(({ url, icon, label }) => {
          return `<a href="${url}"><i class="${icon}"></i>${label}</a>`;
        })
        .join("")}
      </div>
      </section>`;
    }
  });
});

hero.addEventListener("mouseover", function (e) {
  submenu.classList.remove("show");
});
nav.addEventListener("mouseover", function (e) {
  if (!e.target.classList.contains("link-btn")) {
    submenu.classList.remove("show");
  }
});
