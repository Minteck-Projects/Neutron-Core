/**
 * @property {HTMLInputElement} input
 * @property {SpotlightItem[]} items
 * @property {SpotlightItem[]} matchedItems
 * @property {SpotlightItem} activeItem
 * @property {HTMLUListElement} suggestions
 */

class Spotlight extends HTMLElement {

    constructor () {
        super();
        this.shortcutHandler = this.shortcutHandler.bind(this);
        this.hide = this.hide.bind(this);
        this.inputHandler = this.inputHandler.bind(this);
        this.inputShortcutHandler = this.inputShortcutHandler.bind(this);
    }

    connectedCallback () {
        // On construit la structure HTML de spotlight
        this.classList.add('spotlight');
        this.innerHTML = `
            <div class="spotlight-bar">
                <input class="spotlight-input" type="text" placeholder="${this.getAttribute('placeholder')}">
                <ul class="spotlight-suggestions" hidden>
                </ul>
            </div>`;
        
        this.input = this.querySelector('input');
        this.input.addEventListener("blur", (e) => {
            setTimeout(() => {
                this.hide();
            }, 200)
        });

        // On construit la liste de suggestions
        this.suggestions = this.querySelector('.spotlight-suggestions');
        this.items = Array.from(document.querySelectorAll(this.getAttribute('target'))).map(a => {
            const title = a.innerText.trim();
            if (title === '') {
                return null;
            }
            const item = new SpotlightItem(title, a.getAttribute("href"), a.getAttribute("icon"), a.getAttribute("cat"));
            this.suggestions.appendChild(item.element);
            return item;
        }).filter(i => i != null);

        // On écoute les raccourcis
        window.addEventListener("keydown", this.shortcutHandler);
        this.input.addEventListener('input', this.inputHandler);
        this.input.addEventListener('keydown', this.inputShortcutHandler);
    }

    disconnectedCallback () {
        window.removeEventListener("keydown");
    }

    shortcutHandler (e) {
        if (e.key === "k" && e.ctrlKey === true) {
            e.preventDefault();
            this.show();
        }
        if (e.key === "Enter" && e.ctrlKey === true) {
            e.preventDefault();
            this.show();
        }
        if (e.key === " " && e.ctrlKey === true) {
            e.preventDefault();
            this.show();
        }
    }

    show () {
        this.input.disabled = false;
        this.classList.add('active');
        try {
            document.getElementById('admin').classList.add('spotlight-blur');
        } catch (e) {
            console.error(e);
        }
        this.input.value = "";
        this.input.focus();
        this.inputHandler();
    }

    hide () {
        this.classList.remove('active');
        try {
            document.getElementById('admin').classList.remove('spotlight-blur');
        } catch (e) {
            console.error(e);
        }
        this.input.disabled = true;
    }

    inputHandler () {
        const search = this.input.value.trim();
        if (search === '') {
            this.items.forEach(item => item.hide());
            this.matchedItems = [];
            this.suggestions.setAttribute('hidden', 'hidden')
            return;
        }
        let regexp = '^(.*)';
        for (const i in search) {
            regexp += `(${search[i]})(.*)`
        }
        regexp += '$';
        regexp = new RegExp(regexp, 'i');
        this.matchedItems = this.items.filter(item => item.match(regexp));

        if (this.matchedItems.length > 0) {
            this.suggestions.removeAttribute('hidden')
            this.setActiveIndex(0);
        } else {
            this.suggestions.setAttribute('hidden', 'hidden')
        }
    }

    /**
     * 
     * @param {number} n 
     */
    setActiveIndex (n) {
        if (this.activeItem) {
            this.activeItem.unselect();
        }
        if (n >= this.matchedItems.length) {
            n = 0;
        }
        if (n < 0) {
            n = this.matchedItems.length - 1;
        }
        this.matchedItems[n].select();
        this.activeItem = this.matchedItems[n];
    }

    /**
     * 
     * @param {KeyboardEvent} e 
     */
    inputShortcutHandler (e) {
        if (e.key === "Escape") {
            this.hide();
        } else if (e.key === "ArrowDown") {
            const index = this.matchedItems.findIndex(element => element === this.activeItem);
            this.setActiveIndex(index + 1);
        } else if (e.key === "ArrowUp") {
            const index = this.matchedItems.findIndex(element => element === this.activeItem);
            this.setActiveIndex(index - 1);
        } else if (e.key === "Enter") {
            this.activeItem.follow();
            this.hide();
        }
    }

}

/**
 * @property {HTMLLiElement} element
 * @property {string} title
 * @property {string} href
 */
class SpotlightItem {
    /**
     * @param {string} title 
     * @param {string} href 
     * @param {string} icon 
     */
    constructor (title, href, icon, category) {
        const li = document.createElement('li');
        const a = document.createElement('a');
        const text = document.createElement('span');
        const icel = document.createElement('i');
        a.onclick = () => {
            if (window.parent) {
                window.parent.location.hash = href;
            } else {
                window.location.href = href;
            }
        }
        a.classList.add('spotlight-link');
        a.classList.add('spotlight-link__' + category);
        icel.classList.add('material-icons');
        icel.classList.add('spotlight-icon');
        icel.innerHTML = icon;
        text.innerText = title;
        a.appendChild(icel);
        a.appendChild(text);
        li.appendChild(a);
        li.setAttribute('hidden', 'hidden');
        this.element = li;
        this.title = title;
        this.href = href;
        this.hide();
    }

    /**
     * @param {RegExp} regexp 
     * @return {boolean}
     */
    match (regexp) {
        const matches = this.title.match(regexp);
        if (matches === null) {
            this.hide();
            return false;
        }

        this.element.firstChild.children[1].innerHTML = matches.reduce((acc, match, index) => {
            if (index === 0) {
                return acc;
            }
            return acc + (index % 2 === 0 ? `<mark>${match}</mark>` : match);
        }, '')

        this.element.removeAttribute('hidden', 'hidden');
        return true;
    }

    hide () {
        this.element.setAttribute('hidden', 'hidden');
    }

    select () {
        this.element.classList.add('active');
    }

    unselect () {
        this.element.classList.remove('active');
    }

    follow () {
        if (window.parent) {
            window.parent.location.hash = this.href;
        } else {
            window.location.href = this.href;
        }
    }

}

customElements.define("spotlight-bar", Spotlight)
