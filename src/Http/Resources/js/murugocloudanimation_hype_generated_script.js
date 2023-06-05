//	HYPE.documents["MurugoCloud Animation"]

(function () {
    (function m() {
        function k(a, b, c, d) {
            var e = !1;
            null == window[a] &&
                (null == window[b]
                    ? ((window[b] = []),
                        window[b].push(m),
                        (a = document.getElementsByTagName("head")[0]),
                        (b = document.createElement("script")),
                        (e = l),
                        false == !0 && (e = ""),
                        (b.type = "text/javascript"),
                        "" != d &&
                        ((b.integrity = d),
                            b.setAttribute("crossorigin", "anonymous")),
                        (b.src = e + "/" + c),
                        a.appendChild(b))
                    : window[b].push(m),
                    (e = !0));
            return e;
        }
        var l = "MurugoCloud%20Animation.hyperesources",
            f = "MurugoCloud Animation",
            g = "murugocloudanimation_hype_container";
        if (false == !1)
            try {
                for (
                    var c = document.getElementsByTagName("script"), a = 0;
                    a < c.length;
                    a++
                ) {
                    var d = c[a].src,
                        b =
                            null != d
                                ? d.indexOf(
                                    "/murugocloudanimation_hype_generated_script.js"
                                )
                                : -1;
                    if (-1 != b) {
                        l = d.substr(0, b);
                        break;
                    }
                }
            } catch (p) { }
        c =
            null == navigator.userAgentData &&
            navigator.userAgent.match(/MSIE (\d+\.\d+)/);
        c = parseFloat(c && c[1]) || null;
        d =
            !0 == (null != window.HYPE_740F || null != window.HYPE_dtl_740F) ||
            false == !0 ||
            (null != c && 10 > c);
        a = !0 == d ? "HYPE-740.full.min.js" : "HYPE-740.thin.min.js";
        c = !0 == d ? "F" : "T";
        d = d ? "" : "";
        if (
            false == !1 &&
            ((a = k("HYPE_740" + c, "HYPE_dtl_740" + c, a, d)),
                false == !0 &&
                (a =
                    a ||
                    k(
                        "HYPE_w_740",
                        "HYPE_wdtl_740",
                        "HYPE-740.waypoints.min.js",
                        ""
                    )),
                false == !0 &&
                (a =
                    a ||
                    k(
                        "Matter",
                        "HYPE_pdtl_740",
                        "HYPE-740.physics.min.js",
                        ""
                    )),
                a)
        )
            return;
        d = window.HYPE.documents;
        if (null != d[f]) {
            b = 1;
            a = f;
            do f = "" + a + "-" + b++;
            while (null != d[f]);
            for (
                var e = document.getElementsByTagName("div"), b = !1, a = 0;
                a < e.length;
                a++
            )
                if (e[a].id == g && null == e[a].getAttribute("HYP_dn")) {
                    var b = 1,
                        h = g;
                    do g = "" + h + "-" + b++;
                    while (null != document.getElementById(g));
                    e[a].id = g;
                    b = !0;
                    break;
                }
            if (!1 == b) return;
        }
        b = [];
        b = [];
        e = {};
        h = {};
        for (a = 0; a < b.length; a++)
            try {
                (h[b[a].identifier] = b[a].name),
                    (e[b[a].name] = eval(
                        "(function(){return " + b[a].source + "})();"
                    ));
            } catch (n) {
                window.console && window.console.log(n),
                    (e[b[a].name] = function () { });
            }
        c = new window["HYPE_740" + c](
            f,
            g,
            {
                "10": {
                    p: 1,
                    n: "../../../images/MurugoClod.svg",
                    g: "80",
                    t: "image/svg+xml"
                },
                "2": { p: 1, n: "../../../images/Pasted-2.png", g: "25", o: true, t: "@1x" },
                "-2": { n: "blank.gif" },
                "3": { p: 1, n: "../../../images/Pasted-2_2x.png", g: "25", o: true, t: "@2x" },
                "4": { p: 1, n: "../../../images/Pasted-4.png", g: "29", o: true, t: "@1x" },
                "5": { p: 1, n: "../../../images/Pasted-4_2x.png", g: "29", o: true, t: "@2x" },
                "6": { p: 1, n: "../../../images/Pasted-5.png", g: "31", o: true, t: "@1x" },
                "7": { p: 1, n: "../../../images/Pasted-5_2x.png", g: "31", o: true, t: "@2x" },
                "-1": { n: "PIE.htc" },
                "0": { p: 1, n: "../../../images/Pasted.png", g: "9", o: true, t: "@1x" },
                "8": { p: 1, n: "../../../images/Pasted-3.png", g: "33", o: true, t: "@1x" },
                "1": { p: 1, n: "../../../images/Pasted_2x.png", g: "9", o: true, t: "@2x" },
                "9": { p: 1, n: "../../../images/Pasted-3_2x.png", g: "33", o: true, t: "@2x" }
            },
            l,
            [],
            e,
            [
                { n: "Web 1240 Open", o: "1", X: [0, 1, 2, 3] },
                { n: "Phone Screen", o: "96", X: [4] }
            ],
            [
                {
                    o: "207",
                    p: "600px",
                    cA: false,
                    a: 100,
                    Z: 210,
                    Y: 320,
                    c: "#FFF",
                    L: [],
                    bY: 1,
                    d: 320,
                    U: {},
                    T: {
                        "206": {
                            q: false,
                            z: 10,
                            i: "206",
                            n: "Loop Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: -24,
                                    s: -40,
                                    o: "214"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 30,
                                    s: 36,
                                    o: "208"
                                },
                                { y: 0, i: "b", s: 0, z: 0, o: "212", f: "c" },
                                { y: 0, i: "e", s: 1, z: 0, o: "209", f: "c" },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 4,
                                    s: -12,
                                    o: "213"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: -10,
                                    s: -40,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: -20,
                                    s: -56,
                                    o: "210"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: -56,
                                    s: -20,
                                    o: "210"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: -12,
                                    s: 4,
                                    o: "213"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: -40,
                                    s: -24,
                                    o: "214"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 36,
                                    s: 30,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: -40,
                                    s: -10,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "206",
                                                p: 3,
                                                z: false,
                                                symbolOid: "197"
                                            }
                                        ]
                                    },
                                    o: "206"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 36,
                                    z: 0,
                                    o: "208",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -40,
                                    z: 0,
                                    o: "214",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -40,
                                    z: 0,
                                    o: "208",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -56,
                                    z: 0,
                                    o: "210",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -12,
                                    z: 0,
                                    o: "213",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        },
                        kTimelineDefaultIdentifier: {
                            q: false,
                            z: 10,
                            i: "kTimelineDefaultIdentifier",
                            n: "Main Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: -24,
                                    s: -40,
                                    o: "214"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 30,
                                    s: 36,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3.01,
                                    i: "e",
                                    e: 1,
                                    s: 0,
                                    o: "209"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 0,
                                    s: 182,
                                    o: "212"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 4,
                                    s: -12,
                                    o: "213"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: -10,
                                    s: -40,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: -20,
                                    s: -56,
                                    o: "210"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: -56,
                                    s: -20,
                                    o: "210"
                                },
                                {
                                    y: 3.01,
                                    i: "e",
                                    s: 1,
                                    z: 0,
                                    o: "209",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: -12,
                                    s: 4,
                                    o: "213"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: -40,
                                    s: -24,
                                    o: "214"
                                },
                                { y: 5, i: "b", s: 0, z: 0, o: "212", f: "c" },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 36,
                                    s: 30,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: -40,
                                    s: -10,
                                    o: "208"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "206",
                                                p: 3,
                                                z: false,
                                                symbolOid: "197"
                                            }
                                        ]
                                    },
                                    o: "kTimelineDefaultIdentifier"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 36,
                                    z: 0,
                                    o: "208",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -40,
                                    z: 0,
                                    o: "214",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -40,
                                    z: 0,
                                    o: "208",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -56,
                                    z: 0,
                                    o: "210",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: -12,
                                    z: 0,
                                    o: "213",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        }
                    },
                    bZ: 180,
                    O: ["211", "210", "212", "208", "213", "209", "214"],
                    n: "iPhone",
                    _: 0,
                    v: {
                        "213": {
                            w: "",
                            h: "33",
                            p: "no-repeat",
                            x: "visible",
                            a: -12,
                            q: "100% 100%",
                            b: 37,
                            j: "absolute",
                            r: "inline",
                            z: 7,
                            dB: "img",
                            k: "div",
                            d: 226.589,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "209": {
                            h: "80",
                            p: "no-repeat",
                            x: "visible",
                            a: 68,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 4,
                            b: 41,
                            k: "div",
                            d: 19,
                            c: 130,
                            e: 0
                        },
                        "212": {
                            h: "9",
                            p: "no-repeat",
                            x: "visible",
                            a: 198,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            aA: { a: [{ d: 1.1, p: 1, g: 1, e: "96" }] },
                            z: 2,
                            b: 182,
                            d: 91,
                            k: "div",
                            c: 90,
                            aP: "pointer"
                        },
                        "208": {
                            h: "29",
                            p: "no-repeat",
                            x: "visible",
                            a: -40,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 6,
                            b: 36,
                            k: "div",
                            d: 199.262,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "211": {
                            c: 1679,
                            bS: 32,
                            d: 258,
                            I: "None",
                            J: "None",
                            K: "None",
                            g: "#00A3E4",
                            L: "None",
                            M: 0,
                            w: "",
                            N: 0,
                            A: "#D8DDE4",
                            j: "absolute",
                            x: "visible",
                            B: "#D8DDE4",
                            P: 0,
                            O: 0,
                            C: "#D8DDE4",
                            z: 1,
                            k: "div",
                            D: "#D8DDE4",
                            a: -320,
                            b: -51
                        },
                        "214": {
                            w: "",
                            h: "25",
                            p: "no-repeat",
                            x: "visible",
                            a: -40,
                            q: "100% 100%",
                            b: 51,
                            j: "absolute",
                            r: "inline",
                            z: 9,
                            dB: "img",
                            k: "div",
                            d: 233.592,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "210": {
                            w: "",
                            h: "31",
                            p: "no-repeat",
                            x: "visible",
                            a: -56,
                            q: "100% 100%",
                            b: 4,
                            j: "absolute",
                            r: "inline",
                            z: 5,
                            dB: "img",
                            k: "div",
                            d: 232.898,
                            c: 1240,
                            cQ: 1.5,
                            e: 1,
                            cR: 1.5
                        }
                    }
                },
                {
                    o: "184",
                    p: "600px",
                    cA: false,
                    a: 100,
                    Z: 250,
                    Y: 768,
                    c: "#FFF",
                    L: [],
                    bY: 1,
                    d: 768,
                    U: {},
                    T: {
                        "183": {
                            q: false,
                            z: 10,
                            i: "183",
                            n: "Loop Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 296,
                                    s: 280,
                                    o: "219"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 251,
                                    s: 264,
                                    o: "218"
                                },
                                { y: 0, i: "b", s: 2, z: 0, o: "221", f: "c" },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "217"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 6,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 3,
                                    z: 7,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 264,
                                    s: 251,
                                    o: "218"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "217"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 280,
                                    s: 296,
                                    o: "219"
                                },
                                {
                                    f: "c",
                                    y: 6,
                                    z: 4,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                i: 0,
                                                b: "183",
                                                p: 9,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "183"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "216",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "218",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "217",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "219",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "216",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        },
                        kTimelineDefaultIdentifier: {
                            q: false,
                            z: 10,
                            i: "kTimelineDefaultIdentifier",
                            n: "Main Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 296,
                                    s: 280,
                                    o: "219"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3.01,
                                    i: "e",
                                    e: 1,
                                    s: 0,
                                    o: "215"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 10,
                                    s: 232,
                                    o: "221"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "217"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: 255,
                                    s: 264,
                                    o: "218"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: 264,
                                    s: 255,
                                    o: "218"
                                },
                                {
                                    y: 3.01,
                                    i: "e",
                                    s: 1,
                                    z: 0,
                                    o: "215",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "217"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 280,
                                    s: 296,
                                    o: "219"
                                },
                                { y: 5, i: "b", s: 10, z: 0, o: "221", f: "c" },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "216"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "183",
                                                p: 3,
                                                z: false,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "kTimelineDefaultIdentifier"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "216",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "219",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "216",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "218",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "217",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        }
                    },
                    bZ: 180,
                    O: ["220", "221", "215", "218", "216", "217", "219"],
                    n: "iPad Portrait",
                    _: 1,
                    v: {
                        "216": {
                            h: "29",
                            p: "no-repeat",
                            x: "visible",
                            a: 280,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 6,
                            b: 86,
                            k: "div",
                            d: 199.262,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "219": {
                            w: "",
                            h: "25",
                            p: "no-repeat",
                            x: "visible",
                            a: 280,
                            q: "100% 100%",
                            b: 101,
                            j: "absolute",
                            r: "inline",
                            z: 9,
                            dB: "img",
                            k: "div",
                            d: 233.592,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "215": {
                            h: "80",
                            p: "no-repeat",
                            x: "visible",
                            a: 209,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 4,
                            b: 43,
                            k: "div",
                            d: 45,
                            c: 309,
                            e: 0
                        },
                        "218": {
                            w: "",
                            h: "31",
                            p: "no-repeat",
                            x: "visible",
                            a: 264,
                            q: "100% 100%",
                            b: 54,
                            j: "absolute",
                            r: "inline",
                            z: 5,
                            dB: "img",
                            k: "div",
                            d: 232.898,
                            c: 1240,
                            cQ: 1.5,
                            e: 1,
                            cR: 1.5
                        },
                        "221": {
                            h: "9",
                            p: "no-repeat",
                            x: "visible",
                            a: 518,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            aA: { a: [{ d: 1.1, p: 1, g: 1, e: "96" }] },
                            z: 2,
                            b: 232,
                            d: 112,
                            k: "div",
                            c: 111,
                            aP: "pointer"
                        },
                        "217": {
                            w: "",
                            h: "33",
                            p: "no-repeat",
                            x: "visible",
                            a: 308,
                            q: "100% 100%",
                            b: 87,
                            j: "absolute",
                            r: "inline",
                            z: 7,
                            dB: "img",
                            k: "div",
                            d: 226.589,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "220": {
                            c: 1679,
                            bS: 32,
                            d: 258,
                            I: "None",
                            J: "None",
                            K: "None",
                            g: "#00A3E4",
                            L: "None",
                            M: 0,
                            w: "",
                            N: 0,
                            A: "#D8DDE4",
                            j: "absolute",
                            x: "visible",
                            B: "#D8DDE4",
                            P: 0,
                            O: 0,
                            C: "#D8DDE4",
                            z: 1,
                            k: "div",
                            D: "#D8DDE4",
                            a: 0,
                            b: -1
                        }
                    }
                },
                {
                    o: "195",
                    p: "600px",
                    cA: false,
                    a: 100,
                    Z: 250,
                    Y: 1024,
                    c: "#FFF",
                    L: [],
                    bY: 1,
                    d: 1024,
                    U: {},
                    T: {
                        "194": {
                            q: false,
                            z: 10,
                            i: "194",
                            n: "Loop Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 296,
                                    s: 280,
                                    o: "228"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 251,
                                    s: 264,
                                    o: "225"
                                },
                                { y: 0, i: "b", s: 2, z: 0, o: "223", f: "c" },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "227"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 6,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 3,
                                    z: 7,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 264,
                                    s: 251,
                                    o: "225"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "227"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 280,
                                    s: 296,
                                    o: "228"
                                },
                                {
                                    f: "c",
                                    y: 6,
                                    z: 4,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                i: 0,
                                                b: "194",
                                                p: 9,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "194"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "222",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "225",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "227",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "228",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "222",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        },
                        kTimelineDefaultIdentifier: {
                            q: false,
                            z: 10,
                            i: "kTimelineDefaultIdentifier",
                            n: "Main Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 296,
                                    s: 280,
                                    o: "228"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3.01,
                                    i: "e",
                                    e: 1,
                                    s: 0,
                                    o: "224"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 10,
                                    s: 232,
                                    o: "223"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "227"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: 255,
                                    s: 264,
                                    o: "225"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: 264,
                                    s: 255,
                                    o: "225"
                                },
                                {
                                    y: 3.01,
                                    i: "e",
                                    s: 1,
                                    z: 0,
                                    o: "224",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "227"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 280,
                                    s: 296,
                                    o: "228"
                                },
                                { y: 5, i: "b", s: 10, z: 0, o: "223", f: "c" },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "222"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "194",
                                                p: 3,
                                                z: false,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "kTimelineDefaultIdentifier"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "222",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "228",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "222",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "225",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "227",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        }
                    },
                    bZ: 180,
                    O: ["226", "224", "225", "222", "227", "228", "223"],
                    n: "iPad Landscape",
                    _: 2,
                    v: {
                        "226": {
                            c: 1679,
                            bS: 32,
                            d: 258,
                            I: "None",
                            J: "None",
                            K: "None",
                            g: "#00A3E4",
                            L: "None",
                            M: 0,
                            w: "",
                            N: 0,
                            A: "#D8DDE4",
                            j: "absolute",
                            x: "visible",
                            B: "#D8DDE4",
                            P: 0,
                            O: 0,
                            C: "#D8DDE4",
                            z: 1,
                            k: "div",
                            D: "#D8DDE4",
                            a: 0,
                            b: -1
                        },
                        "222": {
                            h: "29",
                            p: "no-repeat",
                            x: "visible",
                            a: 280,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 6,
                            b: 86,
                            k: "div",
                            d: 199.262,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "225": {
                            w: "",
                            h: "31",
                            p: "no-repeat",
                            x: "visible",
                            a: 264,
                            q: "100% 100%",
                            b: 54,
                            j: "absolute",
                            r: "inline",
                            z: 5,
                            dB: "img",
                            k: "div",
                            d: 232.898,
                            c: 1240,
                            cQ: 1.5,
                            e: 1,
                            cR: 1.5
                        },
                        "228": {
                            w: "",
                            h: "25",
                            p: "no-repeat",
                            x: "visible",
                            a: 280,
                            q: "100% 100%",
                            b: 101,
                            j: "absolute",
                            r: "inline",
                            z: 9,
                            dB: "img",
                            k: "div",
                            d: 233.592,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "224": {
                            h: "80",
                            p: "no-repeat",
                            x: "visible",
                            a: 209,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 4,
                            b: 43,
                            k: "div",
                            d: 45,
                            c: 309,
                            e: 0
                        },
                        "227": {
                            w: "",
                            h: "33",
                            p: "no-repeat",
                            x: "visible",
                            a: 308,
                            q: "100% 100%",
                            b: 87,
                            j: "absolute",
                            r: "inline",
                            z: 7,
                            dB: "img",
                            k: "div",
                            d: 226.589,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "223": {
                            h: "9",
                            p: "no-repeat",
                            x: "visible",
                            a: 518,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            aA: { a: [{ d: 1.1, p: 1, g: 1, e: "96" }] },
                            z: 2,
                            b: 232,
                            d: 112,
                            k: "div",
                            c: 111,
                            aP: "pointer"
                        }
                    }
                },
                {
                    o: "3",
                    p: "600px",
                    cA: false,
                    a: 100,
                    Z: 250,
                    Y: 1240,
                    c: "#FFF",
                    L: [],
                    bY: 1,
                    d: 1240,
                    U: {},
                    T: {
                        "65": {
                            q: false,
                            z: 10,
                            i: "65",
                            n: "Loop Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 256,
                                    s: 240,
                                    o: "229"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 251,
                                    s: 264,
                                    o: "233"
                                },
                                { y: 0, i: "b", s: 2, z: 0, o: "235", f: "c" },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "230"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 6,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 3,
                                    z: 7,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 264,
                                    s: 251,
                                    o: "233"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "230"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 240,
                                    s: 256,
                                    o: "229"
                                },
                                {
                                    f: "c",
                                    y: 6,
                                    z: 4,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                i: 0,
                                                b: "65",
                                                p: 9,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "65"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "233",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "234",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "230",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 240,
                                    z: 0,
                                    o: "229",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "234",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        },
                        kTimelineDefaultIdentifier: {
                            q: false,
                            z: 10,
                            i: "kTimelineDefaultIdentifier",
                            n: "Main Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 256,
                                    s: 240,
                                    o: "229"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 92,
                                    s: 86,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3.01,
                                    i: "e",
                                    e: 1,
                                    s: 0,
                                    o: "231"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 10,
                                    s: 232,
                                    o: "235"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 346,
                                    s: 308,
                                    o: "230"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 295,
                                    s: 280,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: 255,
                                    s: 264,
                                    o: "233"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: 264,
                                    s: 255,
                                    o: "233"
                                },
                                {
                                    y: 3.01,
                                    i: "e",
                                    s: 1,
                                    z: 0,
                                    o: "231",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 308,
                                    s: 346,
                                    o: "230"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 240,
                                    s: 256,
                                    o: "229"
                                },
                                { y: 5, i: "b", s: 10, z: 0, o: "235", f: "c" },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 86,
                                    s: 92,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 280,
                                    s: 295,
                                    o: "234"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "65",
                                                p: 3,
                                                z: false,
                                                symbolOid: "2"
                                            }
                                        ]
                                    },
                                    o: "kTimelineDefaultIdentifier"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 86,
                                    z: 0,
                                    o: "234",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 240,
                                    z: 0,
                                    o: "229",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 280,
                                    z: 0,
                                    o: "234",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 264,
                                    z: 0,
                                    o: "233",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 308,
                                    z: 0,
                                    o: "230",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        }
                    },
                    bZ: 180,
                    O: ["232", "231", "235", "233", "229", "234", "230"],
                    n: "Fulll Web",
                    _: 3,
                    v: {
                        "229": {
                            w: "",
                            h: "25",
                            p: "no-repeat",
                            x: "visible",
                            a: 240,
                            q: "100% 100%",
                            b: 78,
                            j: "absolute",
                            r: "inline",
                            z: 9,
                            dB: "img",
                            k: "div",
                            d: 233.592,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "232": {
                            c: 1679,
                            bS: 32,
                            d: 258,
                            I: "None",
                            J: "None",
                            K: "None",
                            g: "#00A3E4",
                            L: "None",
                            M: 0,
                            w: "",
                            N: 0,
                            A: "#D8DDE4",
                            j: "absolute",
                            x: "visible",
                            B: "#D8DDE4",
                            P: 0,
                            O: 0,
                            C: "#D8DDE4",
                            z: 1,
                            k: "div",
                            D: "#D8DDE4",
                            a: 0,
                            b: -1
                        },
                        "235": {
                            h: "9",
                            p: "no-repeat",
                            x: "visible",
                            a: 518,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            aA: { a: [{ d: 1.1, p: 1, g: 1, e: "96" }] },
                            z: 2,
                            b: 232,
                            d: 112,
                            k: "div",
                            c: 111,
                            aP: "pointer"
                        },
                        "231": {
                            h: "80",
                            p: "no-repeat",
                            x: "visible",
                            a: 209,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 4,
                            b: 43,
                            k: "div",
                            d: 45,
                            c: 309,
                            e: 0
                        },
                        "234": {
                            h: "29",
                            p: "no-repeat",
                            x: "visible",
                            a: 280,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 6,
                            b: 86,
                            k: "div",
                            d: 199.262,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "230": {
                            w: "",
                            h: "33",
                            p: "no-repeat",
                            x: "visible",
                            a: 308,
                            q: "100% 100%",
                            b: 87,
                            j: "absolute",
                            r: "inline",
                            z: 7,
                            dB: "img",
                            k: "div",
                            d: 226.589,
                            c: 1240,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "233": {
                            w: "",
                            h: "31",
                            p: "no-repeat",
                            x: "visible",
                            a: 264,
                            q: "100% 100%",
                            b: 54,
                            j: "absolute",
                            r: "inline",
                            z: 5,
                            dB: "img",
                            k: "div",
                            d: 232.898,
                            c: 1240,
                            cQ: 1.5,
                            e: 1,
                            cR: 1.5
                        }
                    }
                },
                {
                    o: "106",
                    p: "600px",
                    cA: false,
                    Y: 375,
                    Z: 812,
                    L: [],
                    c: "#FFF",
                    bY: 1,
                    d: 375,
                    U: {},
                    T: {
                        "115": {
                            q: false,
                            z: 10,
                            i: "115",
                            n: "Loop Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: 110,
                                    s: 130,
                                    o: "239"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 35,
                                    s: 45,
                                    o: "240"
                                },
                                {
                                    y: 0,
                                    i: "b",
                                    s: -17,
                                    z: 0,
                                    o: "238",
                                    f: "c"
                                },
                                { y: 0, i: "e", s: 1, z: 0, o: "236", f: "c" },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 128,
                                    s: 88,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 170,
                                    s: 150,
                                    o: "241"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 159,
                                    s: 119,
                                    o: "242"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: 130,
                                    s: 110,
                                    o: "239"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 150,
                                    s: 170,
                                    o: "241"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 119,
                                    s: 159,
                                    o: "242"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 45,
                                    s: 35,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 88,
                                    s: 128,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "115",
                                                p: 3,
                                                z: false,
                                                symbolOid: "97"
                                            }
                                        ]
                                    },
                                    o: "115"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 45,
                                    z: 0,
                                    o: "240",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 130,
                                    z: 0,
                                    o: "239",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 88,
                                    z: 0,
                                    o: "240",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 150,
                                    z: 0,
                                    o: "241",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 119,
                                    z: 0,
                                    o: "242",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        },
                        kTimelineDefaultIdentifier: {
                            q: false,
                            z: 10,
                            i: "kTimelineDefaultIdentifier",
                            n: "Main Timeline",
                            a: [
                                {
                                    f: "c",
                                    y: 0,
                                    z: 3.01,
                                    i: "e",
                                    e: 1,
                                    s: 0,
                                    o: "236"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 2,
                                    i: "a",
                                    e: 110,
                                    s: 130,
                                    o: "239"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: 35,
                                    s: 45,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "a",
                                    e: 128,
                                    s: 88,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 170,
                                    s: 150,
                                    o: "241"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 4,
                                    i: "a",
                                    e: 159,
                                    s: 119,
                                    o: "242"
                                },
                                {
                                    f: "c",
                                    y: 0,
                                    z: 5,
                                    i: "b",
                                    e: -17,
                                    s: 72,
                                    o: "238"
                                },
                                {
                                    f: "c",
                                    y: 2,
                                    z: 8,
                                    i: "a",
                                    e: 130,
                                    s: 110,
                                    o: "239"
                                },
                                {
                                    y: 3.01,
                                    i: "e",
                                    s: 1,
                                    z: 0,
                                    o: "236",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 150,
                                    s: 170,
                                    o: "241"
                                },
                                {
                                    f: "c",
                                    y: 4,
                                    z: 6,
                                    i: "a",
                                    e: 119,
                                    s: 159,
                                    o: "242"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "b",
                                    e: 45,
                                    s: 35,
                                    o: "240"
                                },
                                {
                                    f: "c",
                                    y: 5,
                                    z: 5,
                                    i: "a",
                                    e: 88,
                                    s: 128,
                                    o: "240"
                                },
                                {
                                    y: 5,
                                    i: "b",
                                    s: -17,
                                    z: 0,
                                    o: "238",
                                    f: "c"
                                },
                                {
                                    f: "c",
                                    p: 2,
                                    y: 10,
                                    z: 0,
                                    i: "ActionHandler",
                                    s: {
                                        a: [
                                            {
                                                b: "115",
                                                p: 3,
                                                z: false,
                                                symbolOid: "97"
                                            }
                                        ]
                                    },
                                    o: "kTimelineDefaultIdentifier"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 130,
                                    z: 0,
                                    o: "239",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "b",
                                    s: 45,
                                    z: 0,
                                    o: "240",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 88,
                                    z: 0,
                                    o: "240",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 150,
                                    z: 0,
                                    o: "241",
                                    f: "c"
                                },
                                {
                                    y: 10,
                                    i: "a",
                                    s: 119,
                                    z: 0,
                                    o: "242",
                                    f: "c"
                                }
                            ],
                            f: 30,
                            b: []
                        }
                    },
                    bZ: 180,
                    O: ["238", "237", "236", "239", "241", "240", "242"],
                    n: "Untitled Layout",
                    _: 4,
                    v: {
                        "239": {
                            w: "",
                            h: "31",
                            p: "no-repeat",
                            x: "visible",
                            a: 130,
                            q: "100% 100%",
                            b: 22,
                            j: "absolute",
                            r: "inline",
                            z: 5,
                            dB: "img",
                            k: "div",
                            d: 145,
                            c: 765,
                            cQ: 1.5,
                            e: 1,
                            cR: 1.5
                        },
                        "242": {
                            w: "",
                            h: "25",
                            p: "no-repeat",
                            x: "visible",
                            a: 119,
                            q: "100% 100%",
                            b: 55,
                            j: "absolute",
                            r: "inline",
                            z: 9,
                            dB: "img",
                            k: "div",
                            d: 145,
                            c: 765,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "238": {
                            h: "9",
                            p: "no-repeat",
                            x: "visible",
                            a: 250,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 2,
                            k: "div",
                            b: 72,
                            d: 101,
                            c: 100
                        },
                        "241": {
                            w: "",
                            h: "33",
                            p: "no-repeat",
                            x: "visible",
                            a: 150,
                            q: "100% 100%",
                            b: 40,
                            j: "absolute",
                            r: "inline",
                            z: 7,
                            dB: "img",
                            k: "div",
                            d: 141,
                            c: 765,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "237": {
                            c: 1023,
                            bS: 32,
                            d: 217,
                            I: "None",
                            J: "None",
                            K: "None",
                            g: "#00A3E4",
                            L: "None",
                            M: 0,
                            w: "",
                            N: 0,
                            A: "#D8DDE4",
                            j: "absolute",
                            x: "visible",
                            B: "#D8DDE4",
                            P: 0,
                            O: 0,
                            C: "#D8DDE4",
                            z: 1,
                            k: "div",
                            D: "#D8DDE4",
                            a: 0,
                            b: -1
                        },
                        "240": {
                            h: "29",
                            p: "no-repeat",
                            x: "visible",
                            a: 88,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 6,
                            b: 45,
                            k: "div",
                            d: 125,
                            c: 772,
                            cQ: 1.5,
                            cR: 1.5
                        },
                        "236": {
                            h: "80",
                            p: "no-repeat",
                            x: "visible",
                            a: 84,
                            dB: "img",
                            q: "100% 100%",
                            j: "absolute",
                            r: "inline",
                            z: 4,
                            b: 15,
                            k: "div",
                            d: 24,
                            c: 160,
                            e: 0
                        }
                    }
                }
            ],
            {},
            h,
            {},
            function (shouldShow, mainContentContainer) {
                var loadingPageID = mainContentContainer.id + "_loading";
                var loadingDiv = document.getElementById(loadingPageID);

                if (shouldShow == true) {
                    if (loadingDiv == null) {
                        loadingDiv = document.createElement("div");
                        loadingDiv.id = loadingPageID;
                        loadingDiv.style.cssText =
                            "overflow:hidden;position:absolute;width:150px;top:40%;left:0;right:0;margin:auto;padding:2px;border:3px solid #BBB;background-color:#EEE;border-radius:10px;text-align:center;font-family:Helvetica,Sans-Serif;font-size:13px;font-weight:700;color:#AAA;z-index:100000;";
                        loadingDiv.innerHTML = "Loading";
                        mainContentContainer.appendChild(loadingDiv);
                    }

                    loadingDiv.style.display = "block";
                    loadingDiv.removeAttribute("aria-hidden");
                    mainContentContainer.setAttribute("aria-busy", true);
                } else {
                    loadingDiv.style.display = "none";
                    loadingDiv.setAttribute("aria-hidden", true);
                    mainContentContainer.removeAttribute("aria-busy");
                }
            },
            false,
            true,
            -1,
            true,
            true,
            false,
            true,
            true
        );
        d[f] = c.API;
        document.getElementById(g).setAttribute("HYP_dn", f);
        c.z_o(this.body);
    })();
})();
