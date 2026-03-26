(() => {
  const STYLE_ID = "mobile-select-modal-styles";
  const BUTTON_CLASS = "mobile-select-button";
  const SELECT_CLASS = "mobile-enhanced-select";
  const OVERLAY_ID = "mobileSelectOverlay";
  const SHEET_ID = "mobileSelectSheet";
  const LIST_ID = "mobileSelectList";
  const TITLE_ID = "mobileSelectTitle";
  const CLOSE_ID = "mobileSelectClose";

  function isMobile() {
    return window.matchMedia && window.matchMedia("(max-width: 900px)").matches;
  }

  function ensureStyles() {
    if (document.getElementById(STYLE_ID)) return;
    const style = document.createElement("style");
    style.id = STYLE_ID;
    style.textContent = `
      @media (max-width: 900px) {
        select.${SELECT_CLASS} { display: none !important; }
        .${BUTTON_CLASS} { display: flex !important; }
      }
      @media (min-width: 901px) {
        .${BUTTON_CLASS} { display: none !important; }
      }
      .${BUTTON_CLASS} {
        width: 100%;
        display: none;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        border: 2px solid #c7da30;
        border-radius: 8px;
        padding: 10px 12px;
        background: #fff;
        color: #111;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
      }
      .${BUTTON_CLASS}::after {
        content: '';
        width: 8px;
        height: 8px;
        border-right: 2px solid #6b7280;
        border-bottom: 2px solid #6b7280;
        transform: rotate(45deg);
        flex: 0 0 auto;
      }
      #${OVERLAY_ID} {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 3000;
        opacity: 0;
        transition: opacity 0.2s ease;
      }
      #${OVERLAY_ID}.active {
        display: block;
        opacity: 1;
      }
      #${SHEET_ID} {
        display: none;
        position: fixed;
        left: 12px;
        right: 12px;
        bottom: 12px;
        max-height: 70vh;
        background: #fff;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.22);
        z-index: 3001;
        overflow: hidden;
      }
      #${SHEET_ID}.active { display: block; }
      #${SHEET_ID} .mobile-select-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-bottom: 1px solid #e5e7eb;
        font-family: 'Montserrat', sans-serif;
      }
      #${TITLE_ID} {
        font-size: 14px;
        font-weight: 800;
        color: #111;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      #${CLOSE_ID} {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex: 0 0 auto;
        font-size: 20px;
        line-height: 1;
      }
      #${LIST_ID} {
        overflow: auto;
        max-height: calc(70vh - 60px);
        -webkit-overflow-scrolling: touch;
      }
      #${LIST_ID} .mobile-select-item {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 14px;
        color: #111;
        cursor: pointer;
      }
      #${LIST_ID} .mobile-select-item[aria-selected="true"] {
        background: #38b6ff;
        color: #fff;
      }
    `;
    document.head.appendChild(style);
  }

  function ensureModal() {
    if (document.getElementById(OVERLAY_ID)) return;
    const overlay = document.createElement("div");
    overlay.id = OVERLAY_ID;
    overlay.setAttribute("aria-hidden", "true");

    const sheet = document.createElement("div");
    sheet.id = SHEET_ID;
    sheet.setAttribute("role", "dialog");
    sheet.setAttribute("aria-modal", "true");
    sheet.innerHTML = `
      <div class="mobile-select-header">
        <div id="${TITLE_ID}"></div>
        <button type="button" id="${CLOSE_ID}" aria-label="Close">×</button>
      </div>
      <div id="${LIST_ID}"></div>
    `;
    document.body.appendChild(overlay);
    document.body.appendChild(sheet);
  }

  function setModalOpen(open) {
    const overlay = document.getElementById(OVERLAY_ID);
    const sheet = document.getElementById(SHEET_ID);
    if (!overlay || !sheet) return;
    overlay.classList.toggle("active", open);
    sheet.classList.toggle("active", open);
    overlay.setAttribute("aria-hidden", (!open).toString());
  }

  function getSelectLabel(select) {
    const aria = select.getAttribute("aria-label");
    if (aria) return aria;
    if (select.id) {
      const label = document.querySelector(`label[for="${CSS.escape(select.id)}"]`);
      if (label) return (label.textContent || "").trim();
    }
    const prev = select.previousElementSibling;
    if (prev && prev.tagName === "LABEL") return (prev.textContent || "").trim();
    return "Select";
  }

  function getSelectedText(select) {
    const opt = select.options[select.selectedIndex];
    return (opt && opt.textContent ? opt.textContent : "").trim() || "Select";
  }

  function openForSelect(select) {
    if (!isMobile()) return;
    ensureStyles();
    ensureModal();

    const titleEl = document.getElementById(TITLE_ID);
    const listEl = document.getElementById(LIST_ID);
    if (!titleEl || !listEl) return;

    titleEl.textContent = getSelectLabel(select);
    listEl.innerHTML = "";

    const currentValue = select.value;
    Array.from(select.options).forEach((opt) => {
      const item = document.createElement("div");
      item.className = "mobile-select-item";
      item.textContent = (opt.textContent || "").trim();
      item.setAttribute("role", "option");
      item.setAttribute("aria-selected", opt.value === currentValue ? "true" : "false");
      item.addEventListener("click", () => {
        select.value = opt.value;
        select.dispatchEvent(new Event("change", { bubbles: true }));
        const btn = select._mobileSelectButton;
        if (btn) btn.firstChild.textContent = getSelectedText(select);
        setModalOpen(false);
      });
      listEl.appendChild(item);
    });

    setModalOpen(true);
  }

  function enhanceSelect(select) {
    if (select._mobileSelectEnhanced) return;
    select._mobileSelectEnhanced = true;
    select.classList.add(SELECT_CLASS);

    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = BUTTON_CLASS;
    btn.appendChild(document.createTextNode(getSelectedText(select)));
    select.parentNode.insertBefore(btn, select.nextSibling);
    select._mobileSelectButton = btn;

    btn.addEventListener("click", () => openForSelect(select));
    select.addEventListener("change", () => {
      btn.firstChild.textContent = getSelectedText(select);
    });
  }

  function init() {
    ensureStyles();
    ensureModal();

    const overlay = document.getElementById(OVERLAY_ID);
    const closeBtn = document.getElementById(CLOSE_ID);
    if (overlay) overlay.addEventListener("click", () => setModalOpen(false));
    if (closeBtn) closeBtn.addEventListener("click", () => setModalOpen(false));
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") setModalOpen(false);
    });

    const selects = document.querySelectorAll("form.filters select, .filter-panel select");
    selects.forEach(enhanceSelect);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();

