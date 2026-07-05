const prefetched = new Set();

function prefetch(url) {
    if (prefetched.has(url)) return;
    prefetched.add(url);

    const link = document.createElement("link");
    link.rel = "prefetch";
    link.href = url;
    link.as = "document";
    document.head.appendChild(link);
}

document.querySelectorAll("a[data-prefetch],a.prefetch").forEach((a) => {
    let t;
    a.addEventListener("mouseenter", () => {
        t = setTimeout(() => prefetch(a.href), 75);
    });
    a.addEventListener("mouseleave", () => clearTimeout(t));
});