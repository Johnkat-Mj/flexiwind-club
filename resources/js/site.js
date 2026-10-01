/*
 * Démos interactives du site marketing (home, templates, playground…).
 * Chaque démo est un composant Alpine : l'état reste dans le navigateur,
 * rien ne part au serveur.
 */

const money = (value) => "$" + value.toLocaleString("en-US");

document.addEventListener("alpine:init", () => {
    /* ------------------------------------------------------------------
     * Home : les trois onglets de la vitrine, avec rotation automatique
     * jusqu'à la première interaction.
     * ------------------------------------------------------------------ */
    Alpine.data("homeShowcase", (blocks = []) => ({
        tabs: ["components", "blocks", "templates"],
        tab: "components",
        picked: false,
        timer: null,

        // Onglet Components
        accent: "#4f46e5",
        swatches: [
            { name: "Indigo", hex: "#4f46e5" },
            { name: "Teal", hex: "#0e7490" },
            { name: "Blue", hex: "#075fb0" },
            { name: "Emerald", hex: "#047857" },
            { name: "Orange", hex: "#c2410c" },
        ],
        inspected: null,
        emailAlerts: true,
        weeklyDigest: false,
        period: "Week",
        opacity: 50,
        githubLinked: false,
        members: [
            { init: "AD", name: "Amara Diallo", email: "amara@acme.test", usage: 69, role: "Admin", checked: true },
            { init: "KS", name: "Kenji Sato", email: "kenji@acme.test", usage: 42, role: "Editor", checked: false },
            { init: "LM", name: "Léa Martin", email: "lea@acme.test", usage: 24, role: "Editor", checked: false },
            { init: "NM", name: "Noah Mbeki", email: "noah@acme.test", usage: 18, role: "Viewer", checked: false },
            { init: "SR", name: "Sofia Rossi", email: "sofia@acme.test", usage: 11, role: "Viewer", checked: false },
            { init: "OB", name: "Omar Benali", email: "omar@acme.test", usage: 7, role: "Viewer", checked: false },
        ],

        // Onglet Blocks
        blocks,
        blockIndex: 0,
        blockView: "preview",
        device: "desktop",

        // Onglet Templates
        template: "crm",
        templatePage: { crm: "dashboard", starter: "settings" },

        init() {
            this.timer = setInterval(() => {
                if (this.picked) {
                    return;
                }
                this.tab = this.tabs[(this.tabs.indexOf(this.tab) + 1) % this.tabs.length];
            }, 8000);
        },
        destroy() {
            clearInterval(this.timer);
        },
        stop() {
            this.picked = true;
        },
        pick(tab) {
            this.tab = tab;
            this.stop();
        },
        inspect(tag) {
            this.inspected = tag;
            this.stop();
        },
        setAccent(swatch) {
            this.accent = swatch.hex;
            this.inspect("--primary: " + swatch.hex + ";");
        },
        get selectedLabel() {
            const count = this.members.filter((member) => member.checked).length;
            return count ? count + " of " + this.members.length + " selected" : this.members.length + " members";
        },
        get block() {
            return this.blocks[this.blockIndex] ?? {};
        },
        stepBlock(direction) {
            this.blockIndex = (this.blockIndex + direction + this.blocks.length) % this.blocks.length;
            this.stop();
        },
        get frameWidth() {
            return { desktop: "100%", tablet: "600px", mobile: "360px" }[this.device];
        },
        get url() {
            if (this.tab === "blocks") {
                return "acme.test/blocks/" + (this.block.id ?? "");
            }
            if (this.tab === "templates") {
                return "acme.test/" + (this.template === "crm" ? "crm" : "planner") + "/" + this.templatePage[this.template];
            }
            return "acme.test/components";
        },
    }));

    /* ------------------------------------------------------------------
     * Home, section « Why » : écran construit en trois commandes.
     * ------------------------------------------------------------------ */
    Alpine.data("buildSteps", () => ({
        step: 3,
        get status() {
            if (this.step === 0) {
                return "empty route";
            }
            return this.step === 3 ? "ready · 3 blocks" : this.step + " of 3 blocks";
        },
    }));

    // Les valeurs de chaque prop suivent celles du vrai x-ui.button.
    Alpine.data("buttonTweaker", () => ({
        intents: {
            solid: ["primary", "neutral", "destructive", "success"],
            soft: ["primary", "destructive", "success", "gray"],
            outline: ["gray"],
            ghost: ["gray", "success"],
        },
        variant: "solid",
        intent: "primary",
        size: "md",
        cycle(list, current) {
            return list[(list.indexOf(current) + 1) % list.length];
        },
        nextVariant() {
            this.variant = this.cycle(Object.keys(this.intents), this.variant);
            if (!this.intents[this.variant].includes(this.intent)) {
                this.intent = this.intents[this.variant][0];
            }
        },
        nextIntent() {
            this.intent = this.cycle(this.intents[this.variant], this.intent);
        },
        nextSize() {
            this.size = this.cycle(["sm", "md", "lg"], this.size);
        },
    }));

    Alpine.data("liveEmail", () => ({
        email: "",
        get state() {
            if (this.email === "") {
                return "idle";
            }
            return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(this.email) ? "valid" : "invalid";
        },
        get hint() {
            return {
                idle: "We'll send the invite to this address.",
                valid: "Looks good.",
                invalid: "Enter a valid email address.",
            }[this.state];
        },
    }));

    /* ------------------------------------------------------------------
     * Démo du template CRM (home + page détail).
     * ------------------------------------------------------------------ */
    Alpine.data("crmDemo", () => ({
        page: "dashboard",
        range: 12,
        titles: {
            dashboard: "Dashboard",
            inbox: "Inbox",
            leads: "Leads",
            contacts: "Contacts",
            deals: "Deals",
            companies: "Companies",
            tasks: "Tasks",
            settings: "Settings",
        },
        empty: {
            inbox: { title: "Inbox zero", text: "Messages from leads and contacts land here, threaded by deal.", cta: "Compose" },
            companies: { title: "No companies yet", text: "Group contacts and deals under the company they belong to.", cta: "Add company" },
            settings: { title: "Workspace settings", text: "Billing, members and integrations live here in the full template.", cta: "Invite member" },
        },
        allBars: [
            ["Jan", 55, 88], ["Feb", 88, 42], ["Mar", 10, 115], ["Apr", 5, 25], ["May", 10, 28], ["Jun", 110, 88],
            ["Jul", 78, 40], ["Aug", 55, 42], ["Sep", 78, 48], ["Oct", 88, 55], ["Nov", 120, 60], ["Dec", 130, 65],
        ],
        leads: [
            { name: "Kenji Sato", company: "Northwind", source: "Referral", status: "Qualified", value: "$8,400", checked: false },
            { name: "Léa Martin", company: "Lumen Labs", source: "Website", status: "Contacted", value: "$3,200", checked: false },
            { name: "Noah Mbeki", company: "Baobab Pay", source: "LinkedIn", status: "New", value: "$12,000", checked: true },
            { name: "Sofia Rossi", company: "Vela", source: "Website", status: "Qualified", value: "$5,600", checked: false },
            { name: "Omar Benali", company: "Atlas Freight", source: "Event", status: "Lost", value: "$2,100", checked: false },
            { name: "Jack Doe", company: "Orbit Retail", source: "Referral", status: "New", value: "$4,750", checked: false },
            { name: "Amara Diallo", company: "Kinetic", source: "Website", status: "Contacted", value: "$6,900", checked: false },
            { name: "Inès Duarte", company: "Solaria", source: "LinkedIn", status: "Qualified", value: "$9,300", checked: false },
        ],
        stageNames: ["New", "Qualified", "Proposal", "Won"],
        stageColors: ["bg-slate-400", "bg-sky-500", "bg-amber-500", "bg-emerald-500"],
        deals: [
            { id: 1, title: "Website redesign", company: "Northwind", value: 8400, stage: 0 },
            { id: 2, title: "Payment API", company: "Baobab Pay", value: 12000, stage: 0 },
            { id: 3, title: "Mobile app", company: "Vela", value: 5600, stage: 1 },
            { id: 4, title: "Support plan", company: "Lumen Labs", value: 3200, stage: 1 },
            { id: 5, title: "Fleet dashboard", company: "Atlas Freight", value: 9300, stage: 2 },
            { id: 6, title: "POS rollout", company: "Orbit Retail", value: 4750, stage: 3 },
        ],
        tasks: [
            { title: "Call Kenji about the renewal", tag: "Sales", due: "Today", done: false },
            { title: "Send the Vela proposal", tag: "Deals", due: "Today", done: false },
            { title: "Prepare the Q4 pipeline review", tag: "Planning", due: "Tue", done: true },
            { title: "Update the Northwind contract", tag: "Legal", due: "Wed", done: false },
            { title: "Follow up with Baobab Pay", tag: "Sales", due: "Thu", done: false },
            { title: "Clean up duplicate contacts", tag: "Ops", due: "Fri", done: true },
            { title: "Book the client kickoff", tag: "Planning", due: "Mon", done: false },
        ],
        contacts: [
            ["KS", "Kenji Sato", "CTO", "Northwind"],
            ["LM", "Léa Martin", "Head of Ops", "Lumen Labs"],
            ["NM", "Noah Mbeki", "Founder", "Baobab Pay"],
            ["SR", "Sofia Rossi", "Product lead", "Vela"],
            ["OB", "Omar Benali", "CFO", "Atlas Freight"],
            ["JD", "Jack Doe", "Buyer", "Orbit Retail"],
        ],
        go(page) {
            this.page = page;
            this.$dispatch("demo-page", { page });
        },
        get bars() {
            return (this.range === 6 ? this.allBars.slice(6) : this.allBars).map(([month, closed, lost]) => ({
                month,
                closed: Math.round((closed / 135) * 100),
                lost: Math.round((lost / 135) * 100),
            }));
        },
        dealsIn(stage) {
            return this.deals.filter((deal) => deal.stage === stage);
        },
        money,
        get wonTotal() {
            return money(this.dealsIn(3).reduce((total, deal) => total + deal.value, 0));
        },
        get openTasks() {
            return this.tasks.filter((task) => !task.done).length;
        },
    }));

    /* ------------------------------------------------------------------
     * Démo du Livewire Starter.
     * ------------------------------------------------------------------ */
    Alpine.data("starterDemo", () => ({
        page: "settings",
        tab: "profile",
        name: "",
        saved: false,
        theme: "system",
        titles: { notes: "Notes", calendar: "Calendar", tasks: "Tasks", settings: "Settings" },
        tasks: [
            { title: "Draft the Q4 roadmap", tag: "Planning", due: "Today", done: false },
            { title: "Review the onboarding copy", tag: "Design", due: "Today", done: true },
            { title: "Set up nightly backups", tag: "Ops", due: "Wed", done: false },
            { title: "Book the client kickoff", tag: "Meeting", due: "Thu", done: false },
            { title: "Close the hiring brief", tag: "Planning", due: "Fri", done: true },
        ],
        get openTasks() {
            return this.tasks.filter((task) => !task.done).length;
        },
        get themeClass() {
            return { light: "light", dark: "dark", system: "" }[this.theme];
        },
        go(page) {
            this.page = page;
            this.$dispatch("demo-page", { page });
        },
        save() {
            this.saved = true;
            setTimeout(() => (this.saved = false), 1600);
        },
        get displayName() {
            return this.name.trim() || "Jack";
        },
    }));

    /* ------------------------------------------------------------------
     * Aperçu d'un template, clair ou sombre, indépendamment du site.
     * ------------------------------------------------------------------ */
    Alpine.data("previewTheme", () => ({
        preference: "system",
        page: "",
        get isDark() {
            if (this.preference === "system") {
                return Alpine.store("theme").isDark;
            }
            return this.preference === "dark";
        },
    }));
});

/* ------------------------------------------------------------------
 * Page Charts : les trois graphiques partagent la même période.
 * ------------------------------------------------------------------ */
document.addEventListener("alpine:init", () => {
    const DATA = {
        "7d": { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], a: [12, 15, 14, 18, 16, 21, 19], b: [7, 8, 6, 9, 11, 10, 12], users: [820, 910, 880, 1020, 990, 1140, 1210], traffic: [44, 27, 18, 11], revenue: "$18,400", revenueDelta: "+6.2%", usersDelta: "+9.1%", visits: "12.4k", visitsDelta: "+4.0%" },
        "30d": { labels: ["Sep 1", "Sep 5", "Sep 10", "Sep 15", "Sep 20", "Sep 25", "Sep 30"], a: [40, 46, 43, 55, 58, 62, 70], b: [22, 20, 26, 24, 30, 28, 33], users: [3100, 3380, 3290, 3720, 3960, 4210, 4580], traffic: [41, 29, 19, 11], revenue: "$74,900", revenueDelta: "+12.8%", usersDelta: "+18.4%", visits: "51.2k", visitsDelta: "+11.3%" },
        "12m": { labels: ["Oct", "Dec", "Feb", "Apr", "Jun", "Aug", "Sep"], a: [120, 138, 131, 160, 172, 190, 214], b: [70, 64, 81, 77, 92, 88, 101], users: [9800, 11200, 12100, 13900, 15600, 17800, 19400], traffic: [38, 31, 20, 11], revenue: "$812,300", revenueDelta: "+41.0%", usersDelta: "+97.9%", visits: "604k", visitsDelta: "+63.5%" },
    };
    const CIRCUMFERENCE = 2 * Math.PI * 70;

    Alpine.data("chartsPage", () => ({
        range: "30d",
        showSubscriptions: true,
        showOneTime: true,
        source: 0,
        sources: [["Organic search", "#4f46e5"], ["Direct", "#0e7490"], ["Referral", "#d97706"], ["Social", "#a1a1aa"]],
        get data() {
            return DATA[this.range];
        },
        get bars() {
            const max = Math.max(...this.data.a, ...this.data.b) * 1.1;
            return this.data.labels.map((label, index) => ({
                label,
                a: this.showSubscriptions ? (this.data.a[index] / max) * 100 : 0,
                b: this.showOneTime ? (this.data.b[index] / max) * 100 : 0,
            }));
        },
        get points() {
            const users = this.data.users;
            const max = Math.max(...users) * 1.12;
            const min = Math.min(...users) * 0.8;
            return users.map((value, index) => [(index / (users.length - 1)) * 800, 220 - ((value - min) / (max - min)) * 220]);
        },
        get linePath() {
            return this.points.map((point, index) => (index ? "L" : "M") + point[0].toFixed(1) + " " + point[1].toFixed(1)).join(" ");
        },
        get lastPointTop() {
            return (this.points[this.points.length - 1][1] / 220) * 100;
        },
        get latestUsers() {
            return this.data.users[this.data.users.length - 1].toLocaleString("en-US");
        },
        get slices() {
            let offset = 0;
            return this.data.traffic.map((value, index) => {
                const length = (value / 100) * CIRCUMFERENCE;
                const slice = {
                    color: this.sources[index][1],
                    width: this.source === index ? 34 : 26,
                    dash: (length - 2).toFixed(1) + " " + (CIRCUMFERENCE - length + 2).toFixed(1),
                    offset: (-offset).toFixed(1),
                };
                offset += length;
                return slice;
            });
        },
    }));
});

/* ------------------------------------------------------------------
 * Playground : un thème Flexiwind construit en direct. Les réglages
 * écrivent les vrais tokens (--primary, --gray-*, --ui-radius…) dans
 * l'iframe d'aperçu, et le même objet produit le CSS à copier.
 * ------------------------------------------------------------------ */
document.addEventListener("alpine:init", () => {
    const ACCENTS = [
        { key: "indigo", name: "Indigo", c5: "#6366f1", c6: "#4f46e5" },
        { key: "flexi", name: "Flexi blue", c5: "oklch(60.8% 0.185 233)", c6: "oklch(53.7% 0.185 230)" },
        { key: "violet", name: "Violet", c5: "#8b5cf6", c6: "#7c3aed" },
        { key: "emerald", name: "Emerald", c5: "#10b981", c6: "#059669" },
        { key: "amber", name: "Amber", c5: "#f59e0b", c6: "#d97706" },
        { key: "orange", name: "Orange", c5: "#f97316", c6: "#ea580c" },
        { key: "rose", name: "Rose", c5: "#f43f5e", c6: "#e11d48" },
        { key: "mono", name: "Mono", c5: "#fafafa", c6: "#18181b", mono: true },
    ];
    const STEPS = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];
    const BASES = {
        zinc: { name: "Zinc", c: ["#fafafa", "#f4f4f5", "#e4e4e7", "#d4d4d8", "#a1a1aa", "#71717a", "#52525b", "#3f3f46", "#27272a", "#18181b", "#09090b"] },
        slate: { name: "Slate", c: ["#f8fafc", "#f1f5f9", "#e2e8f0", "#cbd5e1", "#94a3b8", "#64748b", "#475569", "#334155", "#1e293b", "#0f172a", "#020617"] },
        gray: { name: "Gray", c: ["#f9fafb", "#f3f4f6", "#e5e7eb", "#d1d5db", "#9ca3af", "#6b7280", "#4b5563", "#374151", "#1f2937", "#111827", "#030712"] },
        stone: { name: "Stone", c: ["#fafaf9", "#f5f5f4", "#e7e5e4", "#d6d3d1", "#a8a29e", "#78716c", "#57534e", "#44403c", "#292524", "#1c1917", "#0c0a09"] },
        neutral: { name: "Neutral", c: ["#fafafa", "#f5f5f5", "#e5e5e5", "#d4d4d4", "#a3a3a3", "#737373", "#525252", "#404040", "#262626", "#171717", "#0a0a0a"] },
    };
    const RADII = [["none", "None", "0px", "0"], ["sm", "SM", "4px", "var(--radius-sm)"], ["md", "MD", "6px", "var(--radius-md)"], ["lg", "LG", "8px", "var(--radius-lg)"], ["xl", "XL", "12px", "var(--radius-xl)"], ["2xl", "2XL", "16px", "var(--radius-2xl)"]];
    const FORM_RADII = [["none", "None", "0px", "0"], ["sm", "SM", "4px", "var(--radius-sm)"], ["md", "MD", "6px", "var(--radius-md)"], ["lg", "LG", "8px", "var(--radius-lg)"], ["xl", "XL", "12px", "var(--radius-xl)"], ["full", "Full", "999px", "calc(infinity * 1px)"]];
    const FONTS = [["geist", "Geist", '"Geist Sans"'], ["instrument", "Instrument", '"Instrument Sans"'], ["inter", "Inter", '"Inter"'], ["dm", "DM Sans", '"DM Sans"']];
    const PRESETS = [
        { key: "default", name: "Default", accent: "indigo", base: "zinc", radius: "lg", form: "lg", font: "instrument" },
        { key: "ocean", name: "Ocean", accent: "flexi", base: "slate", radius: "xl", form: "md", font: "inter" },
        { key: "forest", name: "Forest", accent: "emerald", base: "stone", radius: "2xl", form: "full", font: "dm" },
        { key: "ember", name: "Ember", accent: "orange", base: "neutral", radius: "md", form: "sm", font: "geist" },
        { key: "mono", name: "Mono", accent: "mono", base: "zinc", radius: "none", form: "none", font: "geist" },
    ];
    const KEYS = ["accent", "base", "radius", "form", "font"];
    const pickPreset = (preset) => Object.fromEntries(KEYS.map((key) => [key, preset[key]]));

    Alpine.data("playground", () => ({
        accents: ACCENTS,
        bases: Object.entries(BASES).map(([key, base]) => ({ key, ...base })),
        radii: RADII,
        formRadii: FORM_RADII,
        fonts: FONTS,
        presets: PRESETS,
        history: [pickPreset(PRESETS[0])],
        position: 0,
        scene: "components",
        viewport: "desktop",
        customizerOpen: true,
        dark: false,
        copied: false,

        init() {
            this.dark = Alpine.store("theme").isDark;
            this.$watch("config", () => this.apply());
            this.$watch("dark", () => this.apply());
        },
        get config() {
            return this.history[this.position];
        },
        set(patch) {
            const next = { ...this.config, ...patch };
            this.history = this.history.slice(0, this.position + 1).concat([next]);
            this.position = this.history.length - 1;
            this.copied = false;
        },
        undo() {
            if (this.position > 0) this.position--;
        },
        redo() {
            if (this.position < this.history.length - 1) this.position++;
        },
        reset() {
            this.set(pickPreset(PRESETS[0]));
        },
        shuffle() {
            const any = (list) => list[Math.floor(Math.random() * list.length)];
            this.set({ accent: any(ACCENTS).key, base: any(Object.keys(BASES)), radius: any(RADII)[0], form: any(FORM_RADII)[0], font: any(FONTS)[0] });
        },
        get accent() {
            return ACCENTS.find((item) => item.key === this.config.accent) ?? ACCENTS[0];
        },
        get base() {
            return BASES[this.config.base] ?? BASES.zinc;
        },
        get radius() {
            return RADII.find((item) => item[0] === this.config.radius) ?? RADII[3];
        },
        get formRadius() {
            return FORM_RADII.find((item) => item[0] === this.config.form) ?? FORM_RADII[3];
        },
        get font() {
            return FONTS.find((item) => item[0] === this.config.font) ?? FONTS[0];
        },
        get preset() {
            return PRESETS.find((preset) => KEYS.every((key) => preset[key] === this.config[key]));
        },
        get checkboxRadius() {
            return this.config.form === "none" ? "0" : this.config.form === "full" ? "calc(infinity * 1px)" : "var(--radius-sm)";
        },
        tokens() {
            const n = this.base.c;
            const dark = this.dark;
            const accent = this.accent;
            const vars = {
                "--primary": dark ? accent.c5 : accent.c6,
                "--primary-foreground": accent.mono && dark ? n[10] : "#ffffff",
                "--background": dark ? n[10] : "#ffffff",
                "--card": dark ? n[10] : "#ffffff",
                "--popover": dark ? n[10] : "#ffffff",
                "--foreground": dark ? n[3] : n[7],
                "--title-foreground": dark ? "#ffffff" : n[9],
                "--card-foreground": dark ? "#ffffff" : n[9],
                "--popover-foreground": dark ? n[3] : n[7],
                "--muted": dark ? n[9] : n[1],
                "--muted-foreground": dark ? n[4] : n[6],
                "--border": dark ? n[9] : n[2],
                "--input": dark ? n[8] : n[2],
                "--border-strong": dark ? n[7] : n[3],
                "--border-card": dark ? n[8] : n[2],
                "--border-input": dark ? n[8] : n[2],
                "--bg-surface": dark ? "color-mix(in oklab, " + n[9] + " 60%, " + n[10] + ")" : n[0],
                "--bg-subtle": dark ? n[9] : n[1],
                "--ui-radius": this.formRadius[2],
                "--card-radius": this.radius[2],
                "--checkbox-radius": this.config.form === "none" ? "0px" : this.config.form === "full" ? "999px" : "4px",
            };
            STEPS.forEach((step, index) => (vars["--gray-" + step] = n[index]));
            return vars;
        },
        apply() {
            const frame = this.$refs.frame;
            const doc = frame?.contentDocument;
            if (!doc?.documentElement) {
                return;
            }
            const root = doc.documentElement;
            root.classList.toggle("dark", this.dark);
            Object.entries(this.tokens()).forEach(([name, value]) => root.style.setProperty(name, value));
            if (doc.body) {
                doc.body.style.fontFamily = this.font[2] + ", ui-sans-serif, system-ui, sans-serif";
            }
        },
        get frameWidth() {
            return { desktop: "100%", tablet: "834px", mobile: "390px" }[this.viewport];
        },
        get css() {
            const n = this.base.c;
            const lines = ["/* Flexiwind theme: " + (this.preset ? this.preset.name : "Custom") + " */", ":root {"];
            lines.push("  --c-primary-500: " + this.accent.c5 + ";", "  --c-primary-600: " + this.accent.c6 + ";", "");
            STEPS.forEach((step, index) => lines.push("  --gray-" + step + ": " + n[index] + ";"));
            lines.push("", "  --ui-radius: " + this.formRadius[3] + ";", "  --card-radius: " + this.radius[3] + ";", "  --checkbox-radius: " + this.checkboxRadius + ";");
            if (this.accent.mono) {
                lines.push("  --primary: var(--gray-900);");
            }
            lines.push("}");
            if (this.accent.mono) {
                lines.push("", ".dark {", "  --primary: var(--gray-50);", "  --primary-foreground: var(--gray-950);", "}");
            }
            lines.push("", "@theme {", "  --font-sans: " + this.font[2] + ", ui-sans-serif, system-ui, sans-serif;", "}");
            return lines.join("\n");
        },
        copyTheme() {
            navigator.clipboard.writeText(this.css).then(() => {
                this.copied = true;
                setTimeout(() => (this.copied = false), 1600);
            });
        },
    }));

    // Côté iframe : le parent écrit les tokens, la page n'a qu'à suivre la scène.
    Alpine.data("playgroundScene", (initial = "components") => ({
        scene: initial,
    }));
});
