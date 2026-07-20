(() => {
    let a = document.documentElement;
    var e = {
        "data-skin": "skin",
        "data-bs-theme": "theme",
        "data-menu-color": "sidenavColor",
        "data-sidenav-size": "sidenavSize",
        "data-topbar-color": "topbarColor",
        "data-layout-position": "position",
        "data-layout-width": "width",
        dir: "dir",
        "data-sidenav-user": "sidenavUser"
    };

    let i = {};
    Object.entries(e).forEach(([key, val]) => {
        let attr = a.getAttribute(key);
        if (attr !== null) {
            i[val] = "sidenavUser" === val ? "true" === attr : attr;
        }
    });

    let storedConfig = {};
    try {
        let localStr = localStorage.getItem("__THEME_CONFIG__");
        let sessionStr = sessionStorage.getItem("__THEME_CONFIG__");
        let local = localStr ? JSON.parse(localStr) : {};
        let session = sessionStr ? JSON.parse(sessionStr) : {};
        storedConfig = Object.assign({}, local, session);
    } catch (err) {
        storedConfig = {};
    }

    window.skinPresets = {
        flat: { theme: "light", sidenavUser: false, topbarColor: "light", sidenavColor: "dark" },
        luxe: { theme: "light", sidenavUser: true, topbarColor: "dark", sidenavColor: "light" },
        neon: { theme: "light", sidenavUser: false, topbarColor: "gray", sidenavColor: "gray" },
        saas: { theme: "light", sidenavUser: true, topbarColor: "light", sidenavColor: "dark" },
        pixel: { theme: "light", sidenavUser: true, topbarColor: "light", sidenavColor: "gradient" },
        retro: { theme: "light", sidenavUser: true, topbarColor: "light", sidenavColor: "gradient" },
        galaxy: { theme: "dark", sidenavUser: true, topbarColor: "dark", sidenavColor: "light" },
        modern: { theme: "light", sidenavUser: true, topbarColor: "light", sidenavColor: "gradient" },
        default: { theme: "light", sidenavUser: false, topbarColor: "light", sidenavColor: "dark" },
        minimal: { theme: "light", sidenavUser: false, topbarColor: "light", sidenavColor: "gray" },
        material: { theme: "light", sidenavUser: true, topbarColor: "dark", sidenavColor: "light" }
    };

    let baseDefaults = {
        dir: "ltr",
        skin: "default",
        theme: "light",
        width: "fluid",
        position: "fixed",
        orientation: "vertical",
        sidenavSize: "default",
        sidenavUser: false,
        topbarColor: "light",
        sidenavColor: "dark"
    };

    let currentSkin = storedConfig.skin || i.skin || baseDefaults.skin;
    var s = window.skinPresets[currentSkin] || {};

    let o = Object.assign({}, baseDefaults, s, i, storedConfig);

    let urlParams = new URLSearchParams(window.location.search);
    let applyUrlParam = (key, val) => val && (o[key] = "sidenavUser" === key ? "true" === val : val);
    Object.values(e).forEach(val => applyUrlParam(val, urlParams.get(val)));

    window.defaultConfig = structuredClone(baseDefaults);

    let setAttr = (attrName, val) => val && a.setAttribute(attrName, val);
    setAttr("data-skin", (window.config = o).skin);
    setAttr("data-bs-theme", "system" === o.theme ? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light") : o.theme);
    setAttr("data-menu-color", o.sidenavColor);
    setAttr("data-topbar-color", o.topbarColor);
    setAttr("data-layout-width", o.width);
    setAttr("data-layout-position", o.position);
    setAttr("dir", o.dir);

    let size = o.sidenavSize;
    if (window.innerWidth <= 767) {
        size = "offcanvas";
    } else if (window.innerWidth <= 1140 && "offcanvas" !== size) {
        size = "condensed";
    }
    setAttr("data-sidenav-size", size);

    if (o.sidenavUser) {
        a.setAttribute("data-sidenav-user", "true");
    } else {
        a.removeAttribute("data-sidenav-user");
    }
})();