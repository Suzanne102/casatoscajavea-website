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
