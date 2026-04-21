import isDesktop from "./isDesktop";

const calculateChildrenHeight = (el, deep = false) => {
    const children = el.children;

    let height = 0;
    for (let i = 0; i < el.childElementCount; i++) {
        const child = children[i];
        height += child.querySelector(".submenu-link").clientHeight;

        // 2-level menu
        if (deep && child.classList.contains("has-sub")) {
            const subsubmenu = child.querySelector(".submenu");

            if (subsubmenu.classList.contains("submenu-open")) {
                const childrenHeight = ~~[
                    ...subsubmenu.querySelectorAll(".submenu-link"),
                ].reduce((acc, curr) => acc + curr.clientHeight, 0);
                height += childrenHeight;
            }
        }
    }
    el.style.setProperty("--submenu-height", height + "px");
    return height;
};

class Sidebar {
    constructor(el, options = {}) {
        this.sidebarEL =
            el instanceof HTMLElement ? el : document.querySelector(el);
        this.options = options;
        this.init();
    }

    init() {
        document
            .querySelectorAll(".burger-btn")
            .forEach((el) =>
                el.addEventListener("click", this.toggle.bind(this))
            );
        document
            .querySelectorAll(".sidebar-hide")
            .forEach((el) =>
                el.addEventListener("click", this.toggle.bind(this))
            );
        // Toggle button inside sidebar header
        document
            .querySelectorAll(".sidebar-toggle-btn")
            .forEach((el) =>
                el.addEventListener("click", (e) => {
                    e.preventDefault();
                    this.toggle();
                })
            );
        // In mini mode, clicking any icon expands sidebar
        document.querySelectorAll(".sidebar-link").forEach((el) => {
            el.addEventListener("click", (e) => {
                if (!this.sidebarEL.classList.contains("active") && isDesktop(window)) {
                    e.preventDefault();
                    this.show();
                }
            });
        });
        window.addEventListener("resize", this.onResize.bind(this));

        const toggleSubmenu = (el) => {
            if (el.classList.contains("submenu-open")) {
                el.classList.remove("submenu-open");
                el.classList.add("submenu-closed");
                el.classList.remove("active");
            } else {
                el.classList.add("submenu-open");
                el.classList.remove("submenu-closed");
                el.classList.add("active");
            }

            calculateChildrenHeight(el, true);
        };

        let sidebarItems = document.querySelectorAll(".sidebar-item.has-sub");
        for (var i = 0; i < sidebarItems.length; i++) {
            let sidebarItem = sidebarItems[i];

            sidebarItems[i]
                .querySelector(".sidebar-link")
                .addEventListener("click", function (e) {
                    e.preventDefault();
                    let parentItem = this.closest(".sidebar-item.has-sub");
                    let submenu = parentItem.querySelector(":scope > .submenu");
                    toggleSubmenu(submenu);
                });

            const submenuItems = sidebarItem.querySelectorAll(
                ".submenu-item.has-sub"
            );
            submenuItems.forEach((item) => {
                const link = item.querySelector(":scope > a.submenu-link");

                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    let parentItem = this.closest(".submenu-item.has-sub");
                    let submenu = parentItem.querySelector(":scope > .submenu");

                    toggleSubmenu(submenu);
                    calculateChildrenHeight(parentItem.parentElement, true);
                });
            });
        }
        if (typeof PerfectScrollbar == "function") {
            const container = document.querySelector(".sidebar-wrapper");
            const ps = new PerfectScrollbar(container, {
                wheelPropagation: true,
            });
        }

        setTimeout(() => {
            const activeSidebarItem = document.querySelector(
                ".sidebar-item.active"
            );
            if (activeSidebarItem) {
                this.forceElementVisibility(activeSidebarItem);
            }
        }, 300);

        if (this.options.recalculateHeight) {
            reInit_SubMenuHeight(sidebarEl);
        }
    }

    onResize() {
        // On resize, just ensure backdrop is cleaned up
        this.deleteBackdrop();
        this.toggleOverflowBody(true);
    }

    toggle() {
        const sidebarState = this.sidebarEL.classList.contains("active");
        if (sidebarState) {
            this.hide();
        } else {
            this.show();
        }
    }

    show() {
        this.sidebarEL.classList.add("active");
        this.sidebarEL.classList.remove("inactive");
        this.createBackdrop();
        this.toggleOverflowBody();
    }

    hide() {
        this.sidebarEL.classList.remove("active");
        this.sidebarEL.classList.add("inactive");
        this.deleteBackdrop();
        this.toggleOverflowBody();
    }

    createBackdrop() {
        if (isDesktop(window)) return;
        this.deleteBackdrop();
        const backdrop = document.createElement("div");
        backdrop.classList.add("sidebar-backdrop");
        backdrop.addEventListener("click", this.hide.bind(this));
        document.body.appendChild(backdrop);
    }

    deleteBackdrop() {
        const backdrop = document.querySelector(".sidebar-backdrop");
        if (backdrop) {
            backdrop.remove();
        }
    }

    toggleOverflowBody(active) {
        if (isDesktop(window)) return;
        const sidebarState = this.sidebarEL.classList.contains("active");
        const body = document.querySelector("body");
        if (typeof active == "undefined") {
            body.style.overflowY = sidebarState ? "hidden" : "auto";
        } else {
            body.style.overflowY = active ? "auto" : "hidden";
        }
    }

    isElementInViewport(el) {
        var rect = el.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <=
                (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <=
                (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    forceElementVisibility(el) {
        if (!this.isElementInViewport(el)) {
            el.scrollIntoView(false);
        }
    }
}

let sidebarEl = document.getElementById("sidebar");

const onFirstLoad = (sidebarEL) => {
    if (!sidebarEl) return;
    if (isDesktop(window)) {
        sidebarEL.classList.add("active");
        sidebarEL.classList.add("sidebar-desktop");
    } else {
        sidebarEL.classList.remove("active");
        sidebarEL.classList.add("inactive");
        sidebarEL.classList.remove("sidebar-desktop");
    }

    document.querySelectorAll(".submenu-item.active").forEach((activeItem) => {
        const parent = activeItem.closest(".submenu-item.has-sub");
        if (parent) {
            parent.classList.add("active");
        }
    });

    let submenus = document.querySelectorAll(".has-sub > .submenu");
    submenus.forEach((submenu) => {
        const parent = submenu.parentElement;

        if (parent.classList.contains("active")) {
            submenu.classList.add("submenu-open");
        } else {
            submenu.classList.add("submenu-closed");
        }

        setTimeout(() => {
            calculateChildrenHeight(submenu, true);
        }, 50);
    });
};

const reInit_SubMenuHeight = (sidebarEl) => {
    if (!sidebarEl) return;

    let submenus = document.querySelectorAll(".has-sub > .submenu");
    submenus.forEach((submenu) => {
        const parent = submenu.parentElement;

        if (parent.classList.contains("active")) {
            submenu.classList.add("submenu-open");
        } else {
            submenu.classList.add("submenu-closed");
        }

        setTimeout(() => {
            calculateChildrenHeight(submenu, true);
        }, 50);
    });
};

if (document.readyState !== "loading") {
    onFirstLoad(sidebarEl);
} else {
    window.addEventListener("DOMContentLoaded", () => onFirstLoad(sidebarEl));
}
window.Sidebar = Sidebar;

if (sidebarEl) {
    const sidebar = new window.Sidebar(sidebarEl);
}
