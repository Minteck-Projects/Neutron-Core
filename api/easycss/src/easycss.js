EasyCSSLangs = {
    en: {
        selectors: {
            html: "Whole page",
            body: "Page body"
        },
        selectorscats: {
            full: "Full content",
            website: "Website elements",
            html: "Generic elements",
            pseudo: "Pseudo-classes",
        },
        pseudosels: {
            all: "All elements on page",
            select: "Selected text",
            achilds: "Childs alone",
            ulink: "Unvisited Links",
            empty: "Empty Elements",
        },
        htmlsels: {
            a: "Link",
            abbr: "Abbreviation",
            address: "HTML5 Contact Info",
            area: "Image Map Area",
            article: "HTML5 Article",
            aside: "Aside Content",
            audio: "Audio Media",
            b: "Bold Text",
            bdi: "Isolated Text",
            bdo: "Inherited Text",
            blockquote: "Quote Section",
            br: "Line Break",
            button: "Button",
            canvas: "Scripted Graphics",
            caption: "Table Caption",
            center: "HTML4 Centered Text",
            cite: "Italic Text (alt.)",
            code: "Inline Code",
            col: "Column Group Child",
            colgroup: "Column Group",
            data: "Text Metadata",
            datalist: "Data List",
            dd: "Description List Item Description/Value",
            del: "Deleted Text",
            details: "Collapsable Details",
            dfn: "Term Define Instance",
            dialog: "Dialog Box/Window",
            div: "Diviser",
            dl: "Description List",
            dt: "Description List Item Term/Name",
            em: "Emphasized Text",
            embed: "Non-HTML Embed Container",
            fieldset: "Related Elements Group",
            figcaption: "Self-Contained Content Caption",
            figure: "Self-Contained Content",
            footer: "HTML5 Page Footer",
            form: "Controls Form",
            h1: "Heading Level 1",
            h2: "Heading Level 2",
            h3: "Heading Level 3",
            h4: "Heading Level 4",
            h5: "Heading Level 5",
            h6: "Heading Level 6",
            header: "HTML5 Page Header",
            hr: "Horizontal Line",
            i: "Italic Text",
            iframe: "Inline Frame",
            img: "Image",
            input: "Form Control",
            ins: "Lately-Inserted Text",
            kbd: "Keyboard Input",
            label: "Form Control Label",
            legend: "Related Elements Group Caption",
            li: "List Item",
            main: "Main Document Content",
            map: "Client-side Image Map",
            mark: "Highlighted Text",
            meter: "Scalar Measurement",
            nav: "Navigation Links",
            noscript: "Scripts-Disabled Message",
            object: "Embedded Object",
            ol: "Ordered List",
            optgroup: "Dropdown Options Group",
            option: "Dropdown Option",
            output: "Calculation Result",
            p: "Paragraph",
            picture: "Multiple Images Container",
            pre: "Preformatted Text",
            progress: "Task Progress",
            q: "Short Quote",
            rp: "Ruby-Unsupported Message",
            rt: "East Asian Characters Explanation",
            ruby: "Ruby Annotation",
            s: "Strikethrough Text",
            samp: "Sample Program Output",
            section: "Document Section",
            select: "Dropdown List",
            small: "Smaller Text",
            span: "Semi-Isolated Text Section",
            strong: "Bold Text (alt.)",
            sub: "Subscripted Text",
            summary: "Collapsable Details Visible Heading",
            sup: "Superscripted Text",
            svg: "SVG Container",
            table: "Table",
            tbody: "Table Body",
            td: "Table Cell",
            template: "Hidden HTML Template",
            textarea: "Multiline Text Area",
            tfoot: "Table Footer",
            th: "Table Header Cell",
            thead: "Table Header",
            time: "Date/Time",
            tr: "Table Row",
            track: "Media Track",
            u: "Underlined Text",
            ul: "Unordered List",
            video: "Video Content",
            wbr: "Possible Line Break",
        },
        propcats: {
            a: "Animations",
            b: "Background",
            b1: "Border",
            c: "Color",
            d: "Dimension",
            f: "Flexible Box",
            f1: "Font",
            l: "List",
            m: "Margin",
            p: "Padding",
            o: "Outline",
            t: "Text",
            t1: "Text Decoration",
            t2: "Transform and 3D",
            t3: "Transitions",
            v: "Visual Transformations"
        },
        select: {
            prop: "select property",
            element: "select element",
            value: "enter value",
        },
        none: "(none)",
        submit: "Add Property",
        expect: "Expected value(s): ",
        exval: {
            any: "Other value or property-specific value",
            size: "Regular or relative size (%, px, em, cm, in, ...)",
            aio: "All-in-One Property Value",
            time: "Absolute duration (ms, sec or s)",
            color: "Color value (hex, rgb or rgba, hsl, cmyk, ...)",
            file: "Resource document, like src()",
            onezero: "0 to 1 decimal value. e.g. 0.75 or .25",
            cursor: "System Cursor"
        },
        errors: {
            uncomplete: "Some values aren't filled correctly",
        },
        verbose: {
            selector: "On all objects matching ",
            property: ", apply property ",
            value: " value ",
            remove: "Remove Style Rule"
        }
    }
}

const EasyCSS = {
    sessions: {},
    data: {},
    validateFile: function (url) {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status!=404;
    },
    css: function (config) {
        let render = "";

        if (config instanceof Object) {} else {
            if (config === undefined || config === null) {
                config = {
                    lang: "en",
                    wrapper: "#easycss",
                    verbose: false,
                    theme: "none",
                    ctypes: [
                        {
                            name: "Il s'agit d'un test",
                            localized_name: {
                                en: "This is a test",
                                fr: "Il s'agit d'un test"
                            },
                            selector: ".class#id[prop=value]"
                        }
                    ]
                }
            } else {
                throw new EasyCSSInitError("Expected config to be Object, but " + typeof config + " was given");
            }
        }

        if (config.verbose) {
            this.debug = (message) => {
                console.debug("[EasyCSS] " + message);
            }
        } else {
            this.debug = (message) => {
                return;
            }
        }

        if (typeof config.theme === "string") {
            if (config.theme == "none" || config.theme == "null" || config.theme == "no" || config.theme == "") {
                console.warn("EasyCSS: Selecting default browser-specific theme");
            } else {
                if (typeof config.themeImportPath === "string") {
                    EasyCSSCanonicalRoot = config.themeImportPath;
                } else {
                    EasyCSSCanonicalRootArray = document.getElementsByTagName('script')[0].src.split("/")
                    EasyCSSCanonicalRootArray.pop()
                    EasyCSSCanonicalRootArray.pop()
                    EasyCSSCanonicalRoot = EasyCSSCanonicalRootArray.join("/") + "/themes";
                }
                if (EasyCSS.validateFile(EasyCSSCanonicalRoot + "/" + config.theme + ".css")) {
                    console.log(document.currentScript);
                    var head = document.getElementsByTagName('HEAD')[0];
                    var link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.type = 'text/css';
                    link.href = EasyCSSCanonicalRoot + "/" + config.theme + ".css";
                    head.appendChild(link);
                } else {
                    console.warn("EasyCSS: Selected theme not found, falling back to default browser-specific theme");
                }
            }
        } else {
            throw new EasyCSSInitError("Missing theme property, no theme selected");
        }

        this.debug("Config parsed, setting up EasyCSS");

        this.config = config;

        this.append = (html) => {
            render = render + html;
        }

        this.appendHTMLTagDefinition = (tag) => {
            render = render + "<option value=\"htmlsel:" + tag + "\">&lt;" + tag + "&gt; : " + this.lang.htmlsels[tag] + "</option>";
        }

        this.render = () => {
            this.wrapper.innerHTML = render;
        }

        if (typeof document.querySelector(config.wrapper) != "undefined") {
            this.wrapper = document.querySelector(config.wrapper)
            this.wrapper.innerHTML = '<div style="text-align: center;"><svg class="spinner" width="48px" height="48px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div><style>.spinner {-webkit-animation: rotator 1.4s linear infinite;animation: rotator 1.4s linear infinite;text-align:center;}@-webkit-keyframes rotator {0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}100% {-webkit-transform: rotate(270deg);transform: rotate(270deg);}}@keyframes rotator {0% {-webkit-transform: rotate(0deg);transform: rotate(0deg);}100% {-webkit-transform: rotate(270deg);transform: rotate(270deg);}}.path {stroke-dasharray: 187;stroke-dashoffset: 0;transform-origin: center;stroke: gray;animation: dash 1.4s ease-in-out infinite;}@keyframes dash {0% {stroke-dashoffset: 187;}50% {stroke-dashoffset: 46.75;-webkit-transform: rotate(135deg);transform: rotate(135deg);}100% {stroke-dashoffset: 187;-webkit-transform: rotate(450deg);transform: rotate(450deg);}}</style>'
        }

        if (typeof EasyCSSLangs[config.lang] != "undefined" && typeof EasyCSSLangs[config.lang] != "null") {
            this.lang = EasyCSSLangs[config.lang];
        } else {
            this.lang = EasyCSSLangs["en"];
        }

        this.instance = Math.round(Math.random() * 10000000000000000);
        this.append("<select class=\"easycss-input-selector easycss-block\" id=\"" + this.instance + "-source\"><option value=\"null\" selected disabled> - " + this.lang.select.element + " - </option>");

        this.append("<optgroup label=\"" + this.lang.selectorscats.full + "\"><option value=\"html\">" + this.lang.selectors.html + "</option><option value=\"body\">" + this.lang.selectors.body + "</option></optgroup>");

        this.append("<optgroup label=\"" + this.lang.selectorscats.website + "\">");
        let found = 0;
        if (config.ctypes instanceof Array) {
            config.ctypes.forEach((e, i) => {
                let commonName;
                let pe = "<option value=\"";
                if (e instanceof Object) {
                    if (e.localized_name instanceof Object) {
                        if (e.localized_name[config.lang] == undefined || e.localized_name[config.lang] == null) {
                            commonName = e.name;
                        } else {
                            commonName = e.localized_name[config.lang];
                        }
                    } else {
                        if (e.localized_name == undefined || e.localized_name == null) {
                            commonName = e.name;
                        } else {
                            throw new EasyCSSInitError("Custom type #" + i + "'s localized names isn't an object");
                            commonName = "";
                        }
                    }
                    let selector = e.selector;
                    pe = pe + "custom:" + selector + "\">" + commonName + "</option>";
                    this.append(pe);
                    found = found + 1;
                } else {
                    throw new EasyCSSInitError("Custom type #" + i + " isn't an object");
                }
            });
            if (found < 1) {
                this.append("<option disabled>" + this.lang.none + "</option>");
            }
        } else {
            throw new EasyCSSInitError("Custom types isn't an array");
        }
        this.append("</optgroup>");

        this.append("<optgroup label=\"" + this.lang.selectorscats.html + "\">");

        this.appendHTMLTagDefinition("a");
        this.appendHTMLTagDefinition("abbr");
        this.appendHTMLTagDefinition("address");
        this.appendHTMLTagDefinition("area");
        this.appendHTMLTagDefinition("article");
        this.appendHTMLTagDefinition("aside");
        this.appendHTMLTagDefinition("audio");
        this.appendHTMLTagDefinition("b");
        this.appendHTMLTagDefinition("bdi");
        this.appendHTMLTagDefinition("bdo");
        this.appendHTMLTagDefinition("blockquote");
        this.appendHTMLTagDefinition("br");
        this.appendHTMLTagDefinition("button");
        this.appendHTMLTagDefinition("canvas");
        this.appendHTMLTagDefinition("caption");
        this.appendHTMLTagDefinition("center");
        this.appendHTMLTagDefinition("cite");
        this.appendHTMLTagDefinition("code");
        this.appendHTMLTagDefinition("col");
        this.appendHTMLTagDefinition("colgroup");
        this.appendHTMLTagDefinition("data");
        this.appendHTMLTagDefinition("datalist");
        this.appendHTMLTagDefinition("dd");
        this.appendHTMLTagDefinition("del");
        this.appendHTMLTagDefinition("details");
        this.appendHTMLTagDefinition("dfn");
        this.appendHTMLTagDefinition("dialog");
        this.appendHTMLTagDefinition("div");
        this.appendHTMLTagDefinition("dl");
        this.appendHTMLTagDefinition("dt");
        this.appendHTMLTagDefinition("em");
        this.appendHTMLTagDefinition("embed");
        this.appendHTMLTagDefinition("fieldset");
        this.appendHTMLTagDefinition("figcaption");
        this.appendHTMLTagDefinition("figure");
        this.appendHTMLTagDefinition("footer");
        this.appendHTMLTagDefinition("form");
        this.appendHTMLTagDefinition("h1");
        this.appendHTMLTagDefinition("h2");
        this.appendHTMLTagDefinition("h3");
        this.appendHTMLTagDefinition("h4");
        this.appendHTMLTagDefinition("h5");
        this.appendHTMLTagDefinition("h6");
        this.appendHTMLTagDefinition("header");
        this.appendHTMLTagDefinition("hr");
        this.appendHTMLTagDefinition("i");
        this.appendHTMLTagDefinition("iframe");
        this.appendHTMLTagDefinition("img");
        this.appendHTMLTagDefinition("input");
        this.appendHTMLTagDefinition("ins");
        this.appendHTMLTagDefinition("kbd");
        this.appendHTMLTagDefinition("label");
        this.appendHTMLTagDefinition("legend");
        this.appendHTMLTagDefinition("li");
        this.appendHTMLTagDefinition("main");
        this.appendHTMLTagDefinition("map");
        this.appendHTMLTagDefinition("mark");
        this.appendHTMLTagDefinition("meter");
        this.appendHTMLTagDefinition("nav");
        this.appendHTMLTagDefinition("noscript");
        this.appendHTMLTagDefinition("object");
        this.appendHTMLTagDefinition("ol");
        this.appendHTMLTagDefinition("optgroup");
        this.appendHTMLTagDefinition("option");
        this.appendHTMLTagDefinition("output");
        this.appendHTMLTagDefinition("p");
        this.appendHTMLTagDefinition("picture");
        this.appendHTMLTagDefinition("pre");
        this.appendHTMLTagDefinition("progress");
        this.appendHTMLTagDefinition("q");
        this.appendHTMLTagDefinition("rp");
        this.appendHTMLTagDefinition("rt");
        this.appendHTMLTagDefinition("ruby");
        this.appendHTMLTagDefinition("s");
        this.appendHTMLTagDefinition("samp");
        this.appendHTMLTagDefinition("section");
        this.appendHTMLTagDefinition("select");
        this.appendHTMLTagDefinition("small");
        this.appendHTMLTagDefinition("span");
        this.appendHTMLTagDefinition("strong");
        this.appendHTMLTagDefinition("sub");
        this.appendHTMLTagDefinition("svg");
        this.appendHTMLTagDefinition("table");
        this.appendHTMLTagDefinition("tbody");
        this.appendHTMLTagDefinition("td");
        this.appendHTMLTagDefinition("template");
        this.appendHTMLTagDefinition("textarea");
        this.appendHTMLTagDefinition("tfoot");
        this.appendHTMLTagDefinition("th");
        this.appendHTMLTagDefinition("thead");
        this.appendHTMLTagDefinition("time");
        this.appendHTMLTagDefinition("tr");
        this.appendHTMLTagDefinition("track");
        this.appendHTMLTagDefinition("u");
        this.appendHTMLTagDefinition("ul");
        this.appendHTMLTagDefinition("video");
        this.appendHTMLTagDefinition("wbr");

        this.append("</optgroup>");

        this.append("<optgroup label=\"" + this.lang.selectorscats.pseudo + "\"><option value=\"all\">" + this.lang.pseudosels.all + "</option><option value=\"select\">" + this.lang.pseudosels.select + "</option><option value=\"achilds\">" + this.lang.pseudosels.achilds + "</option><option value=\"ulink\">" + this.lang.pseudosels.ulink + "</option><option value=\"empty\">" + this.lang.pseudosels.empty + "</option></optgroup>");

        this.append("</select>");

        this.append(` <select class=\"easycss-input-property easycss-block\" onchange="EasyCSS.validateProperty(${this.instance})" id="${this.instance}-property"><option value="null" selected disabled> - ${this.lang.select.prop} - </option><optgroup label="${this.lang.propcats.a}"><option value="animation">All-in-One Animation Property</option><option value="animation-delay">Animation Delay</option><option value="animation-direction">Animation Direction</option><option value="animation-duration">Animation Duration</option><option value="animation-fill-mode">Animation Fill Mode</option><option value="animation-iteration-count">Animation Repeat Times</option><option value="animation-name">Selected Animation Name</option><option value="animation-play-state">Animation State</option><option value="animation-timing-function">Animation Progress Method</option></optgroup><optgroup label="${this.lang.propcats.b}"><option value="background">All-in-One Background Property</option><option value="background-attachment">Background Scroll Reactivity</option><option value="background-clip">Background Painting Area</option><option value="background-color">Background Color</option><option value="background-image">Background Image Source</option><option value="background-origin">Background Image Positioning Area</option><option value="background-position">Background Origin</option><option value="background-repeat">Background Tiling</option><option value="background-size">Background Image Size</option></optgroup><optgroup label="${this.lang.propcats.b1}"><option value="border">All-in-One Border Property</option><option value="border-bottom">All-in-One Bottom Border Property</option><option value="border-top">All-in-One Top Border Property</option><option value="border-left">All-in-One Left Border Property</option><option value="border-right">All-in-One Right Border Property</option><option value="border-bottom-color">Bottom Border Color</option><option value="border-top-color">Top Border Color</option><option value="border-left-color">Left Border Color</option><option value="border-right-color">Right Border Color</option><option value="border-top-left-radius">Top Border Left Radius</option><option value="border-top-right-radius">Top Border Right Radius</option><option value="border-bottom-left-radius">Bottom Border Left Radius</option><option value="border-bottom-right-radius">Bottom Border Right Radius</option><option value="border-bottom-style">Bottom Border Style</option><option value="border-top-style">Top Border Style</option><option value="border-left-style">Left Border Style</option><option value="border-right-style">Right Border Style</option><option value="border-bottom-width">Bottom Border Width</option><option value="border-top-width">Top Border Width</option><option value="border-left-width">Left Border Width</option><option value="border-right-width">Right Border Width</option><option value="border-color">Border Color</option><option value="border-width">Border Width</option><option value="border-style">Border Style</option><option value="border-radius">Border Radius</option><option value="border-image">All-in-One Border Image Property</option><option value="border-image-outset">Border Image Outset</option><option value="border-image-repeat">Border Image Repeat Style</option><option value="border-image-slice">Border Image Inward Offset</option><option value="border-image-source">Border Image Source</option><option value="border-image-width">Border Image Width</option></optgroup><optgroup label="${this.lang.propcats.c}"><option value="color">Text Color</option><option value="opacity">Opacity</option></optgroup><optgroup label="${this.lang.propcats.d}"><option value="height">Height</option><option value="width">Width</option><option value="min-height">Minimal Height</option><option value="min-width">Minimal Width</option><option value="max-height">Maximal Height</option><option value="max-width">Maximal Width</option></optgroup><optgroup label="${this.lang.propcats.f}"><option value="align-content">Flexible Container Items Align</option><option value="align-items">Default Flexible Container Items Align</option><option value="align-self">Selected Flexible Container Items Align</option><option value="flex">Flexible Length Components</option><option value="flex-basis">Flexible Item Initial Main Size</option><option value="flex-direction">Flexible Items Direction</option><option value="flex-grow">Flexible Item Grow Relativity</option><option value="flex-shrink">Flexible Item Shrink Relativity</option><option value="flex-wrap">Flexible Items Wrap Mode</option><option value="justify-content">Flexible Items Justify Mode</option><option value="order">Flexible Items Order</option></optgroup><optgroup label="${this.lang.propcats.f1}"><option value="font-family">Font Family</option><option value="font-size">Font Size</option><option value="font-size-adjust">Fallback Font Readability Preservation</option><option value="font-stretch">Font Stretching</option><option value="font-style">Font Style</option><option value="font-variant">Font Variant</option><option value="font-weight">Font Weight</option></optgroup><optgroup label="${this.lang.propcats.l}"><option value="list-style">List Display Style</option><option value="list-style-image">List Bullet Image</option><option value="list-style-position">List Bullet Position</option><option value="list-style-type">List Bullet Style</option></optgroup><optgroup label="${this.lang.propcats.m}"><option value="margin">All-in-One Margin Property</option><option value="margin-top">Top Margin</option><option value="margin-bottom">Bottom Margin</option><option value="margin-left">Left Margin</option><option value="margin-right">Right Margin</option></optgroup><optgroup label="${this.lang.propcats.p}"><option value="padding">All-in-One Padding Property</option><option value="padding-top">Top Padding</option><option value="padding-bottom">Bottom Padding</option><option value="padding-left">Left Padding</option><option value="padding-right">Right Padding</option></optgroup><optgroup label="${this.lang.propcats.o}"><option value="outline">All-in-One Outline Property</option><option value="outline-color">Outline Color</option><option value="outline-offset">Outline-Border Offset</option><option value="outline-style">Outline Style</option><option value="outline-width">Outline Width</option></optgroup><optgroup label="${this.lang.propcats.t}"><option value="direction">Text Direction</option><option value="tab-size">Tab Character Size</option><option value="text-align">Text Alignment</option><option value="text-shadow">Text Shadow</option><option value="line-height">Lines Height</option><option value="vertical-align">Vertical Alignment</option><option value="letter-spacing">Space Between Letters</option><option value="word-spacing">Space Between Words</option><option value="white-space">Whitespace Handling</option><option value="text-justify">Text Justify</option><option value="text-indent">Text Indent</option><option value="text-transform">Text Case Tranform</option></optgroup><optgroup label="${this.lang.propcats.t1}"><option value="text-decoration">All-in-One Decoration Property</option><option value="text-decoration-color">Decoration Color</option><option value="text-decoration-line">Decoration Line</option><option value="text-decoration-style">Decoration Style</option></optgroup><optgroup label="${this.lang.propcats.t2}"><option value="backface-visibility">Back Side Always Visible</option><option value="perspective">View Perspective</option><option value="perspective-origin">Perspective Vanishing Point</option><option value="transform">2D or 3D Transformation</option><option value="transform-origin">Transformation Origin</option><option value="transform-style">3D Nested Elements Rendering</option></optgroup><optgroup label="${this.lang.propcats.t3}"><option value="transition">All-in-One Transition Property</option><option value="transition-delay">Transition Delay</option><option value="transition-duration">Transition Duration</option><option value="transition-property">Transition Changed Property</option><option value="transition-timing-function">Transition Speed Curve</option></optgroup><optgroup label="${this.lang.propcats.v}"><option value="display">Display Method</option><option value="position">Element Position</option><option value="top">Top Edge Position</option><option value="right">Right Edge Position</option><option value="bottom">Bottom Edge Position</option><option value="left">Left Edge Position</option><option value="float">Box Float</option><option value="clear">Float Element Placement</option><option value="z-index">Stacking Order</option><option value="overflow">Overflow Content Method</option><option value="overflow-x">Horizontal Overflow Content Method</option><option value="overflow-y">Vertical Overflow Content Method</option><option value="resize">Resizable</option><option value="clip">Clipping Region</option><option value="visibility">Element Visibility</option><option value="cursor">Cursor</option><option value="box-shadow">Element Shadow</option><option value="box-sizing">Box Model Alteration</option></optgroup></select>`);

        this.append(" <input class=\"easycss-input-value easycss-block\" id=\"" + this.instance + "-value\" type=\"text\" placeholder=\" - " + this.lang.select.value + " - \"> <a class=\"easycss-button-add  easycss-block\" href=\"#\" onclick=\"EasyCSS.addNewOption(" + this.instance + ");\">" + this.lang.submit + "</a><br><b class=\"easycss-expected-prefix\">" + this.lang.expect + "</b><span class=\"easycss-expected-value\" id=\"" + this.instance + "-expect\">" + this.lang.exval.any + "</span><hr class=\"easycss-separator\"><div class=\"easycss-list\" id=\"" + this.instance + "-list\"></div>")

        this.render();
        EasyCSS.sessions[this.instance] = this;
        EasyCSS.data[this.instance] = [];
        this.debug("Set up!");
    },
    validateProperty: function (session) {
        if (typeof document.getElementById(session + "-property") != "undefined" && typeof document.getElementById(session + "-property") != "null") {
            match = false;
            property = document.getElementById(session + "-property").value;
            if (property.includes("width") || property.includes("height") || property.includes("margin") || property.includes("top") || property.includes("bottom") || property.includes("left") || property.includes("right") || property.includes("size") || property.includes("radius")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.size;
            }
            if (property.includes("color")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.color;
            }
            if (property.includes("delay") || property.includes("duration")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.time;
            }
            if (property.includes("source") || property.includes("src") || property == "background-image") {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.file;
            }
            if (property.includes("opacity")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.onezero;
            }
            if (property.includes("cursor")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.cursor;
            }
            if (property == "border" || property == "border-right" || property == "border-left" || property == "border-top" || property == "border-bottom" || property == "background" || property == "animation" || property == "border-image" || property == "margin" || property == "padding" || property == "outline" || property == "decoration" || property == "transition" || property.includes("shadow")) {
                match = true;
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.aio;
            }
            if (!match) {
                document.getElementById(session + "-expect").innerHTML = EasyCSS.sessions[session].lang.exval.any;
            }
        }
    },
    addNewOption: function (session) {
        property = document.getElementById(session + "-property").value;
        element = document.getElementById(session + "-source").value;
        value = document.getElementById(session + "-value").value;
        document.getElementById(session + "-property").disabled = true;
        document.getElementById(session + "-source").disabled = true;
        document.getElementById(session + "-value").disabled = true;

        if (property == "null" || element == "null" || value.trim() == "") {
            alert(EasyCSS.sessions[session].lang.errors.uncomplete);
            document.getElementById(session + "-property").disabled = false;
            document.getElementById(session + "-source").disabled = false;
            document.getElementById(session + "-value").disabled = false;
            EasyCSS.reloadList(session);
            return;
        }

        if (element.startsWith("htmlsel:")) {
            he = element.replace("htmlsel:", "");
            selector = he;
        }

        if (element.startsWith("custom:")) {
            he = element.replace("custom:", "");
            selector = he;
        }

        if (element == "html") {
            selector = "html";
        }

        if (element == "body") {
            selector = "body";
        }

        if (element == "all") {
            selector = "*";
        }

        if (element == "select") {
            selector = "*::select";
        }

        if (element == "achilds") {
            selector = "*:only-child";
        }

        if (element == "ulink") {
            selector = "*:link";
        }

        if (element == "empty") {
            selector = "*:empty";
        }

        abort = false;
        id = Math.round(Math.random() * 10000000000000000);
        o = {selector: selector, property: property, value: value, id: id};
        s = JSON.stringify(o);
        EasyCSS.data[session].forEach((e, i) => {
            if (s === JSON.stringify(e)) {
                abort = true;
            }
        });
        if (!abort) {
            EasyCSS.data[session].push(o);
        }

        document.getElementById(session + "-property").value = "null";
        document.getElementById(session + "-source").value = "null";
        document.getElementById(session + "-value").value = "";
        document.getElementById(session + "-property").disabled = false;
        document.getElementById(session + "-source").disabled = false;
        document.getElementById(session + "-value").disabled = false;
        EasyCSS.reloadList(session);
    },
    reloadList: function (session) {
        elements = "<ul>";
        EasyCSS.data[session].forEach((e, i) => {
            if (typeof e != "undefined" && typeof e != "null" && e != null) {
                elements = elements + "<li class=\"easycss-list-item\">" + EasyCSS.sessions[session].lang.verbose.selector + "<b>" + e.selector + "</b>" + EasyCSS.sessions[session].lang.verbose.property + "<b>" + e.property + "</b>" + EasyCSS.sessions[session].lang.verbose.value + "<b>" + e.value + "</b>" + " <span class=\"easycss-list-separator\">— </span><a class=\"easycss-button-remove  easycss-block\" href=\"#\" onclick=\"EasyCSS.removeOption(" + e.id + "," + session + "," + i + ")\">" + EasyCSS.sessions[session].lang.verbose.remove + "</a></li>";
            }
        })
        elements = elements + "</ul>";
        document.getElementById(session + "-list").innerHTML = elements;
    },
    removeOption: function (id, session, index) {
        option = EasyCSS.data[session][index]
        if (option == undefined || option == null) {
            throw new EasyCSSFunctionException("No specified rule matched given ID");
        }
        EasyCSS.data[session][index] = undefined;
        EasyCSS.reloadList(session);
    },
    getJsonOutput: function (session) {
        return JSON.stringify(EasyCSS.data[session]);
    },
    loadJsonInput: function (session, input) {
        EasyCSS.data[session] = JSON.parse(input);
        EasyCSS.reloadList(session);
    },
    getOutput: function (session) {
        return EasyCSS.data[session];
    },
    getCssOutput: function (session) {
        output = "/* EasyCSS, better CSS generator — converted from JSON */";
        EasyCSS.data[session].forEach((e, i) => {
            if (e == undefined || e == null) {} else {
                output = output + e.selector + "{/* ID: " + e.id + ", Index: " + i + " */" + e.property + ":" + e.value + ";}";
            }
        })
        return output;
    }
}

class EasyCSSInitError extends Error {
    constructor(message) {
        super(message);
        this.name = "EasyCSSInitError";
    }
}

class EasyCSSFunctionException extends Error {
    constructor(message) {
        super(message);
        this.name = "EasyCSSFunctionException";
    }
}