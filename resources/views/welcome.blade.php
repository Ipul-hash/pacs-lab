<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RadView — DICOM Viewer</title>

<!-- Cornerstone & DICOM Libraries - Pinned stable versions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://unpkg.com/dicom-parser@1.8.21/dist/dicomParser.min.js"></script>
<script src="https://unpkg.com/cornerstone-core@2.6.1/dist/cornerstone.min.js"></script>
<script src="https://unpkg.com/cornerstone-math@0.1.10/dist/cornerstoneMath.min.js"></script>
<script src="https://unpkg.com/cornerstone-wado-image-loader@4.13.2/dist/cornerstoneWADOImageLoader.bundle.min.js"></script>
<script src="https://unpkg.com/cornerstone-tools@6.0.10/dist/cornerstoneTools.min.js"></script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap');

  :root {
    --bg-0: #080c10;
    --bg-1: #0d1117;
    --bg-2: #161b22;
    --bg-3: #1c2230;
    --border: #21262d;
    --border-bright: #30363d;
    --text-0: #e6edf3;
    --text-1: #8b949e;
    --text-2: #484f58;
    --accent: #00d4ff;
    --accent-dim: rgba(0,212,255,0.08);
    --accent-border: rgba(0,212,255,0.2);
    --green: #3fb950;
    --yellow: #d29922;
    --red: #f85149;
    --orange: #e3963e;
  }

  * { margin:0; padding:0; box-sizing:border-box; }

  body {
    font-family: 'IBM Plex Sans', sans-serif;
    background: var(--bg-0);
    color: var(--text-0);
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  /* ── TOPBAR ── */
  .topbar {
    height: 44px;
    background: var(--bg-1);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 16px;
    gap: 24px;
    flex-shrink: 0;
    z-index: 100;
  }

  .logo {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 14px;
    font-weight: 500;
    color: var(--accent);
    letter-spacing: 0.1em;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .logo-icon {
    width: 20px; height: 20px;
    border: 1.5px solid var(--accent);
    border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
  }

  .topbar-nav { display:flex; gap:2px; flex:1; }

  .nav-btn {
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 12px;
    color: var(--text-1);
    cursor: pointer;
    border: none;
    background: transparent;
    font-family: inherit;
    transition: all 0.15s;
  }
  .nav-btn:hover { background:var(--bg-3); color:var(--text-0); }
  .nav-btn.active { background:var(--accent-dim); color:var(--accent); border:1px solid var(--accent-border); }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 11px;
    color: var(--text-1);
    font-family: 'IBM Plex Mono', monospace;
  }

  .status-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 6px var(--green);
    animation: pulse 2s infinite;
  }
  .status-dot.offline { background:var(--red); box-shadow:0 0 6px var(--red); }

  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

  /* ── MAIN ── */
  .main { display:flex; flex:1; overflow:hidden; }

  /* ── SIDEBAR ── */
  .sidebar {
    width: 260px;
    background: var(--bg-1);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
  }

  .sidebar-header {
    padding: 10px 14px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .sidebar-title {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-1);
  }

  .badge {
    background: var(--bg-3);
    border: 1px solid var(--border-bright);
    color: var(--text-1);
    font-size: 10px;
    padding: 1px 6px;
    border-radius: 10px;
    font-family: 'IBM Plex Mono', monospace;
  }

  .search-box {
    padding: 8px 10px;
    border-bottom: 1px solid var(--border);
  }

  .search-input {
    width: 100%;
    background: var(--bg-2);
    border: 1px solid var(--border-bright);
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 12px;
    color: var(--text-0);
    font-family: 'IBM Plex Mono', monospace;
    outline: none;
    transition: border-color 0.15s;
  }
  .search-input::placeholder { color:var(--text-2); }
  .search-input:focus { border-color:var(--accent); }

  .list-container {
    flex: 1;
    overflow-y: auto;
    padding: 6px 0;
  }
  .list-container::-webkit-scrollbar { width:4px; }
  .list-container::-webkit-scrollbar-thumb { background:var(--border-bright); border-radius:2px; }

  .study-item {
    padding: 10px 14px;
    cursor: pointer;
    border-left: 2px solid transparent;
    transition: all 0.15s;
  }
  .study-item:hover { background:var(--bg-2); }
  .study-item.active { background:var(--accent-dim); border-left-color:var(--accent); }

  .study-patient {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-0);
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .study-meta { display:flex; gap:6px; align-items:center; flex-wrap:wrap; }

  .study-id {
    font-size: 10px;
    color: var(--text-1);
    font-family: 'IBM Plex Mono', monospace;
  }

  .mod-tag {
    font-size: 9px;
    padding: 1px 5px;
    border-radius: 3px;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }
  .tag-ct { background:rgba(0,212,255,0.12); color:var(--accent); }
  .tag-mr { background:rgba(63,185,80,0.12); color:var(--green); }
  .tag-cr { background:rgba(227,150,62,0.12); color:var(--orange); }
  .tag-us { background:rgba(210,153,34,0.12); color:var(--yellow); }
  .tag-other { background:var(--bg-3); color:var(--text-1); }

  .loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    gap: 12px;
    color: var(--text-2);
  }

  .spinner {
    width: 24px; height: 24px;
    border: 2px solid var(--border-bright);
    border-top-color: var(--accent);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }
  @keyframes spin { to { transform:rotate(360deg); } }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    gap: 8px;
    color: var(--text-2);
    font-size: 12px;
    text-align: center;
    font-family: 'IBM Plex Mono', monospace;
  }

  /* ── VIEWER ── */
  .viewer-area { flex:1; display:flex; flex-direction:column; overflow:hidden; }

  .toolbar {
    height: 40px;
    background: var(--bg-2);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 12px;
    gap: 4px;
    flex-shrink: 0;
  }

  .tool-btn {
    width: 30px; height: 30px;
    border-radius: 5px;
    background: transparent;
    border: 1px solid transparent;
    color: var(--text-1);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    transition: all 0.15s;
    font-family: inherit;
  }
  .tool-btn:hover { background:var(--bg-3); color:var(--text-0); border-color:var(--border-bright); }
  .tool-btn.active { background:var(--accent-dim); color:var(--accent); border-color:var(--accent-border); }

  .tool-sep { width:1px; height:20px; background:var(--border); margin:0 6px; }

  .toolbar-right { margin-left:auto; display:flex; align-items:center; gap:8px; }

  .info-bar {
    font-size: 11px;
    color: var(--text-1);
    font-family: 'IBM Plex Mono', monospace;
    display: flex;
    gap: 16px;
  }
  .info-bar span { color:var(--text-0); }

  .layout-btn {
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 4px;
    background: transparent;
    border: 1px solid var(--border-bright);
    color: var(--text-1);
    cursor: pointer;
    font-family: 'IBM Plex Mono', monospace;
    transition: all 0.15s;
  }
  .layout-btn:hover, .layout-btn.active { background:var(--accent-dim); color:var(--accent); border-color:var(--accent-border); }

  /* ── VIEWPORT ── */
  .viewport-grid {
    flex: 1;
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
    gap: 2px;
    background: var(--bg-0);
    padding: 2px;
    overflow: hidden;
  }
  .viewport-grid.two-col { grid-template-columns:1fr 1fr; grid-template-rows:1fr; }
  .viewport-grid.quad { grid-template-columns:1fr 1fr; grid-template-rows:1fr 1fr; }

  .viewport {
    background: #000;
    position: relative;
    overflow: hidden;
  }
  .viewport.active-vp::after {
    content: '';
    position: absolute;
    inset: 0;
    border: 1.5px solid var(--accent);
    pointer-events: none;
    z-index: 10;
  }

  .cs-container { width:100%; height:100%; position:relative; }

  .vp-overlay {
    position: absolute;
    inset: 0;
    padding: 8px;
    pointer-events: none;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    z-index: 5;
  }

  .vp-text {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 10px;
    color: rgba(255,255,255,0.7);
    line-height: 1.6;
    text-shadow: 0 1px 3px rgba(0,0,0,0.9);
  }
  .vp-text.right { text-align:right; }
  .vp-corner { display:flex; justify-content:space-between; align-items:flex-end; }

  .vp-label {
    position: absolute;
    top: 8px; right: 8px;
    font-size: 9px;
    color: rgba(255,255,255,0.3);
    font-family: 'IBM Plex Mono', monospace;
    letter-spacing: 0.1em;
    z-index: 6;
  }

  .no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 12px;
    color: var(--text-2);
    position: absolute;
    inset: 0;
    z-index: 2;
  }
  .no-image-icon { font-size:40px; opacity:0.2; }
  .no-image-text { font-size:11px; font-family:'IBM Plex Mono',monospace; }

  /* ── RIGHT PANEL ── */
  .right-panel {
    width: 220px;
    background: var(--bg-1);
    border-left: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    overflow-y: auto;
  }
  .right-panel::-webkit-scrollbar { width:4px; }
  .right-panel::-webkit-scrollbar-thumb { background:var(--border-bright); }

  .panel-section { border-bottom:1px solid var(--border); padding:10px 12px; }

  .panel-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-2);
    margin-bottom: 8px;
    font-weight: 600;
  }

  .info-row { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:5px; }
  .info-key { font-size:10px; color:var(--text-1); font-family:'IBM Plex Mono',monospace; }
  .info-val { font-size:10px; color:var(--text-0); font-family:'IBM Plex Mono',monospace; text-align:right; max-width:120px; word-break:break-all; }

  .series-list { display:flex; flex-direction:column; gap:4px; }

  .series-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 8px;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid var(--border);
    background: var(--bg-2);
    transition: all 0.15s;
  }
  .series-item:hover { border-color:var(--border-bright); }
  .series-item.active-series { border-color:var(--accent); background:var(--accent-dim); }

  .series-thumb-mini {
    width: 32px; height: 32px;
    background: #111;
    border-radius: 3px;
    flex-shrink: 0;
  }

  .series-info { flex:1; min-width:0; }
  .series-name { font-size:11px; color:var(--text-0); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .series-count { font-size:9px; color:var(--text-1); font-family:'IBM Plex Mono',monospace; }

  .slider-group { margin-bottom:8px; }
  .slider-label { display:flex; justify-content:space-between; font-size:10px; color:var(--text-1); margin-bottom:4px; font-family:'IBM Plex Mono',monospace; }
  .slider-val { color:var(--accent); }

  input[type=range] {
    width: 100%;
    appearance: none;
    height: 3px;
    background: var(--bg-3);
    border-radius: 2px;
    outline: none;
  }
  input[type=range]::-webkit-slider-thumb {
    appearance: none;
    width: 12px; height: 12px;
    border-radius: 50%;
    background: var(--accent);
    cursor: pointer;
    box-shadow: 0 0 6px rgba(0,212,255,0.4);
  }

  /* ── FILMSTRIP ── */
  .filmstrip {
    height: 72px;
    background: var(--bg-1);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 12px;
    gap: 6px;
    overflow-x: auto;
    flex-shrink: 0;
  }
  .filmstrip::-webkit-scrollbar { height:3px; }
  .filmstrip::-webkit-scrollbar-thumb { background:var(--border-bright); }

  .film-item {
    width: 54px; height: 54px;
    flex-shrink: 0;
    background: #111;
    border-radius: 4px;
    border: 1px solid var(--border);
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: border-color 0.15s;
  }
  .film-item:hover { border-color:var(--border-bright); }
  .film-item.active-film { border-color:var(--accent); }

  .film-num {
    position: absolute;
    bottom: 2px; right: 4px;
    font-size: 8px;
    color: rgba(255,255,255,0.4);
    font-family: 'IBM Plex Mono', monospace;
  }

  /* ── TOAST ── */
  .toast {
    position: fixed;
    bottom: 24px; right: 24px;
    background: var(--bg-2);
    border: 1px solid var(--border-bright);
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 12px;
    color: var(--text-0);
    z-index: 9999;
    display: none;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    max-width: 320px;
  }
  .toast.show { display:flex; animation:toastIn 0.25s ease; }
  @keyframes toastIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <div class="logo">
    <div class="logo-icon">✦</div>
    RadView
  </div>
  <div class="topbar-nav">
    <button class="nav-btn active">Studies</button>
    <button class="nav-btn" onclick="refreshStudies()">↻ Refresh</button>
  </div>
  <div class="topbar-right">
    <div class="status-dot" id="status-dot"></div>
    <span id="status-text">Connecting...</span>
  </div>
</div>

<!-- MAIN -->
<div class="main">

  <!-- LEFT SIDEBAR -->
  <div class="sidebar">
    <div class="sidebar-header">
      <span class="sidebar-title">Studies</span>
      <span class="badge" id="study-count">0</span>
    </div>
    <div class="search-box">
      <input class="search-input" type="text" placeholder="Cari patient / StudyUID..." oninput="filterStudies(this.value)">
    </div>
    <div class="list-container" id="study-list">
      <div class="loading-state">
        <div class="spinner"></div>
        <span style="font-size:11px;font-family:'IBM Plex Mono',monospace;">Loading studies...</span>
      </div>
    </div>
  </div>

  <!-- VIEWER AREA -->
  <div class="viewer-area">
    <div class="toolbar">
      <button class="tool-btn active" onclick="setTool('Wwwl',this)" title="W/L">◐</button>
      <button class="tool-btn" onclick="setTool('Pan',this)" title="Pan">✥</button>
      <button class="tool-btn" onclick="setTool('Zoom',this)" title="Zoom">⊕</button>
      <button class="tool-btn" onclick="setTool('Length',this)" title="Measure">⌀</button>
      <div class="tool-sep"></div>
      <button class="tool-btn" onclick="invertImage()" title="Invert">◑</button>
      <button class="tool-btn" onclick="resetViewport()" title="Reset">⌂</button>
      <div class="toolbar-right">
        <div class="info-bar">
          <span id="bar-patient">—</span>
          <span id="bar-acc">—</span>
          <span id="bar-img">—</span>
        </div>
        <div class="tool-sep"></div>
        <button class="layout-btn active" onclick="setLayout('',this)">1×1</button>
        <button class="layout-btn" onclick="setLayout('two-col',this)">1×2</button>
        <button class="layout-btn" onclick="setLayout('quad',this)">2×2</button>
      </div>
    </div>

    <div class="viewport-grid" id="viewport-grid">
      <div class="viewport active-vp" onclick="setActiveVp(this)">
        <div class="cs-container" id="cs-element"></div>
        <div class="vp-overlay">
          <div style="display:flex;justify-content:space-between;">
            <div class="vp-text" id="vp-tl">—</div>
            <div class="vp-text right" id="vp-tr">—</div>
          </div>
          <div class="vp-corner">
            <div class="vp-text" id="vp-bl">WW: — / WL: —</div>
            <div class="vp-text right" id="vp-br">—</div>
          </div>
        </div>
        <div class="no-image" id="no-image">
          <div class="no-image-icon">⬛</div>
          <div class="no-image-text">Pilih study untuk ditampilkan</div>
        </div>
        <span class="vp-label">AX</span>
      </div>
    </div>

    <div class="filmstrip" id="filmstrip">
      <span style="font-size:11px;color:var(--text-2);font-family:'IBM Plex Mono',monospace;">Pilih study...</span>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="right-panel">
    <div class="panel-section">
      <div class="panel-label">Patient Info</div>
      <div class="info-row"><span class="info-key">Name</span><span class="info-val" id="p-name">—</span></div>
      <div class="info-row"><span class="info-key">ID</span><span class="info-val" id="p-id">—</span></div>
      <div class="info-row"><span class="info-key">DOB</span><span class="info-val" id="p-dob">—</span></div>
      <div class="info-row"><span class="info-key">Sex</span><span class="info-val" id="p-sex">—</span></div>
    </div>
    <div class="panel-section">
      <div class="panel-label">Study Info</div>
      <div class="info-row"><span class="info-key">Date</span><span class="info-val" id="s-date">—</span></div>
      <div class="info-row"><span class="info-key">Modality</span><span class="info-val" id="s-modality">—</span></div>
      <div class="info-row"><span class="info-key">Desc</span><span class="info-val" id="s-desc">—</span></div>
      <div class="info-row"><span class="info-key">Images</span><span class="info-val" id="s-images">—</span></div>
    </div>
    <div class="panel-section">
      <div class="panel-label">Series</div>
      <div class="series-list" id="series-list">
        <div style="font-size:11px;color:var(--text-2);font-family:'IBM Plex Mono',monospace;">Pilih study...</div>
      </div>
    </div>
    <div class="panel-section">
      <div class="panel-label">Window</div>
      <div class="slider-group">
        <div class="slider-label">WW <span class="slider-val" id="ww-display">—</span></div>
        <input type="range" min="1" max="4000" value="400" id="ww-slider" oninput="applyWWWL()">
      </div>
      <div class="slider-group">
        <div class="slider-label">WL <span class="slider-val" id="wl-display">—</span></div>
        <input type="range" min="-1000" max="1000" value="40" id="wl-slider" oninput="applyWWWL()">
      </div>
    </div>
    <div class="panel-section">
      <div class="panel-label">Presets</div>
      <div style="display:flex;flex-wrap:wrap;gap:4px;">
        <button class="layout-btn" onclick="setPreset(400,40)">Soft</button>
        <button class="layout-btn" onclick="setPreset(1500,-600)">Lung</button>
        <button class="layout-btn" onclick="setPreset(2500,480)">Bone</button>
        <button class="layout-btn" onclick="setPreset(80,40)">Brain</button>
        <button class="layout-btn" onclick="setPreset(350,60)">Abdomen</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast">
  <span id="toast-icon">ℹ️</span>
  <span id="toast-msg"></span>
</div>

<script>
// ─── CONFIG ─────────────────────────────────────────────
const ORTHANC   = 'http://10.164.96.189:3001/orthanc';
const WADO_ROOT = `${ORTHANC}/dicom-web`;
// ────────────────────────────────────────────────────────

// ─── STATE ──────────────────────────────────────────────
let allStudies    = [];
let currentStudy  = null;
let instanceList  = [];
let currentImgIdx = 0;
let csEnabled     = false;
// ────────────────────────────────────────────────────────

// ─── CORNERSTONE INIT ───────────────────────────────────
cornerstoneWADOImageLoader.external.cornerstone  = cornerstone;
cornerstoneWADOImageLoader.external.dicomParser  = dicomParser;
cornerstoneTools.external.cornerstone            = cornerstone;
cornerstoneTools.external.cornerstoneMath        = cornerstoneMath;
cornerstoneTools.external.Hammer                 = Hammer;

cornerstoneWADOImageLoader.configure({ useWebWorkers: false });

// Init cornerstone tools
try {
  cornerstoneTools.init({
    globalToolSyncEnabled: false,
    showSVGCursors: false,
    autoResizeViewports: false,
  });
} catch(e) { console.warn('cs-tools init:', e); }

function initCS() {
  if (csEnabled) return;
  const el = document.getElementById('cs-element');
  cornerstone.enable(el);
  csEnabled = true;

  // Register tools - safely
  const tools = [
    cornerstoneTools.WwwlTool,
    cornerstoneTools.PanTool,
    cornerstoneTools.ZoomTool,
    cornerstoneTools.LengthTool,
    cornerstoneTools.StackScrollMouseWheelTool,
  ];

  tools.forEach(tool => {
    try { cornerstoneTools.addTool(tool); } catch(e) {}
  });

  try { cornerstoneTools.setToolActive('Wwwl', { mouseButtonMask: 1 }); } catch(e) {}
  try { cornerstoneTools.setToolActive('Pan',  { mouseButtonMask: 4 }); } catch(e) {}
  try { cornerstoneTools.setToolActive('StackScrollMouseWheel', {}); }    catch(e) {}

  el.addEventListener('cornerstoneimagerendered', (e) => {
    try {
      const vp = cornerstone.getViewport(e.target);
      if (!vp) return;
      const ww = Math.round(vp.voi.windowWidth);
      const wl = Math.round(vp.voi.windowCenter);
      document.getElementById('vp-bl').textContent      = `WW: ${ww} / WL: ${wl}`;
      document.getElementById('ww-display').textContent = ww;
      document.getElementById('wl-display').textContent = wl;
      document.getElementById('ww-slider').value        = ww;
      document.getElementById('wl-slider').value        = wl;
      const idx = currentImgIdx + 1;
      const tot = instanceList.length;
      document.getElementById('vp-br').textContent  = `Img: ${idx}/${tot}`;
      document.getElementById('bar-img').textContent = `Img ${idx}/${tot}`;
    } catch(e) {}
  });
}

// ─── GET ORTHANC INTERNAL ID ────────────────────────────
async function getOrthancId(sopInstanceUID) {
  const res  = await fetch(`${ORTHANC}/tools/lookup`, {
    method: 'POST',
    headers: { 'Content-Type': 'text/plain' },
    body: sopInstanceUID  // plain text, bukan JSON.stringify
  });
  const data = await res.json();
  if (data && data.length > 0) return data[0].ID;
  return null;
}

// ─── LOAD IMAGE ─────────────────────────────────────────
async function loadImage(instanceUID, seriesUID, studyUID) {
  initCS();
  const el = document.getElementById('cs-element');
  document.getElementById('no-image').style.display = 'none';

  try {
    const orthancId = await getOrthancId(instanceUID);
    if (!orthancId) throw new Error('Instance tidak ditemukan');

    // wadouri + /instances/{id}/file — paling stable
    const imageId = `wadouri:${ORTHANC}/instances/${orthancId}/file`;
    const image   = await cornerstone.loadAndCacheImage(imageId);
    cornerstone.displayImage(el, image);
  } catch(err) {
    showToast('Gagal load image: ' + err.message, '❌');
    console.error('loadImage error:', err);
  }
}

// ─── FETCH STUDIES ──────────────────────────────────────
async function fetchStudies() {
  document.getElementById('study-list').innerHTML =
    `<div class="loading-state"><div class="spinner"></div><span style="font-size:11px;font-family:'IBM Plex Mono',monospace;">Loading...</span></div>`;

  try {
    const res  = await fetch(`${WADO_ROOT}/studies`, { headers:{ Accept:'application/json' } });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    allStudies = await res.json();
    setOnline();
    renderStudies(allStudies);
  } catch(e) {
    setOffline();
    document.getElementById('study-list').innerHTML =
      `<div class="empty-state"><span style="font-size:20px;">⚠️</span><span>Gagal connect ke Orthanc</span><span style="font-size:10px;">${e.message}</span></div>`;
  }
}

function renderStudies(studies) {
  const list = document.getElementById('study-list');
  document.getElementById('study-count').textContent = studies.length;

  if (!studies.length) {
    list.innerHTML = `<div class="empty-state"><span style="font-size:20px;">📂</span><span>Belum ada study</span></div>`;
    return;
  }

  list.innerHTML = '';
  studies.forEach(s => {
    const name     = getTag(s,'00100010') || 'Unknown';
    const pid      = getTag(s,'00100020') || '—';
    const modality = getTag(s,'00080061') || getTag(s,'00080060') || '—';
    const date     = formatDate(getTag(s,'00080020'));
    const uid      = getTag(s,'0020000D');
    const desc     = getTag(s,'00081030') || '—';
    const nimages  = getTag(s,'00201208') || '—';
    const acc      = getTag(s,'00080050') || '—';

    const div = document.createElement('div');
    div.className = 'study-item';
    div.innerHTML = `
      <div class="study-patient">${name}</div>
      <div class="study-meta">
        <span class="study-id">${pid}</span>
        <span class="mod-tag ${getTagClass(modality)}">${modality}</span>
        <span class="study-id">${date}</span>
      </div>
    `;
    div.onclick = () => {
      document.querySelectorAll('.study-item').forEach(x => x.classList.remove('active'));
      div.classList.add('active');
      selectStudy({ name, pid, modality, date, uid, desc, nimages, acc, raw: s });
    };
    list.appendChild(div);
  });
}

// ─── SELECT STUDY ───────────────────────────────────────
async function selectStudy(info) {
  currentStudy = info;

  document.getElementById('p-name').textContent      = info.name;
  document.getElementById('p-id').textContent        = info.pid;
  document.getElementById('p-dob').textContent       = formatDate(getTag(info.raw,'00100030'));
  document.getElementById('p-sex').textContent       = getTag(info.raw,'00100040') || '—';
  document.getElementById('s-date').textContent      = info.date;
  document.getElementById('s-modality').textContent  = info.modality;
  document.getElementById('s-desc').textContent      = info.desc;
  document.getElementById('s-images').textContent    = info.nimages;

  document.getElementById('bar-patient').textContent = info.name;
  document.getElementById('bar-acc').textContent     = info.acc;
  document.getElementById('vp-tl').innerHTML = `${info.name}<br>${info.pid}`;
  document.getElementById('vp-tr').innerHTML = `${info.desc}<br>${info.date}`;

  await fetchSeries(info.uid);
}

// ─── FETCH SERIES ───────────────────────────────────────
async function fetchSeries(studyUID) {
  const sl = document.getElementById('series-list');
  sl.innerHTML = `<div class="loading-state"><div class="spinner"></div></div>`;

  try {
    const res  = await fetch(`${WADO_ROOT}/studies/${studyUID}/series`, { headers:{ Accept:'application/json' } });
    const data = await res.json();
    sl.innerHTML = '';

    data.forEach((s, i) => {
      const seriesUID  = getTag(s,'0020000E');
      const seriesDesc = getTag(s,'0008103E') || `Series ${i+1}`;
      const numInst    = getTag(s,'00201209') || '?';
      const mod        = getTag(s,'00080060') || '—';

      const item = document.createElement('div');
      item.className = `series-item ${i === 0 ? 'active-series' : ''}`;
      item.innerHTML = `
        <div class="series-thumb-mini" style="background:radial-gradient(ellipse at 50% 50%,#444 0%,#111 70%,#000 100%)"></div>
        <div class="series-info">
          <div class="series-name">${seriesDesc}</div>
          <div class="series-count">${mod} · ${numInst} img</div>
        </div>
      `;
      item.onclick = () => {
        document.querySelectorAll('.series-item').forEach(x => x.classList.remove('active-series'));
        item.classList.add('active-series');
        selectSeries(seriesUID, studyUID);
      };
      sl.appendChild(item);

      if (i === 0) selectSeries(seriesUID, studyUID);
    });
  } catch(e) {
    sl.innerHTML = `<div class="empty-state">Gagal load series</div>`;
  }
}

// ─── SELECT SERIES ──────────────────────────────────────
async function selectSeries(seriesUID, studyUID) {
  currentImgIdx = 0;

  try {
    const res  = await fetch(`${WADO_ROOT}/studies/${studyUID}/series/${seriesUID}/instances`, { headers:{ Accept:'application/json' } });
    const data = await res.json();

    data.sort((a,b) => {
      return (parseInt(getTag(a,'00200013'))||0) - (parseInt(getTag(b,'00200013'))||0);
    });

    instanceList = data.map(d => getTag(d,'00080018'));
    buildFilmstrip(instanceList, seriesUID, studyUID);

    if (instanceList.length > 0) {
      await loadImage(instanceList[0], seriesUID, studyUID);
    }
  } catch(e) {
    showToast('Gagal load instances: ' + e.message, '❌');
  }
}

// ─── FILMSTRIP ──────────────────────────────────────────
function buildFilmstrip(instances, seriesUID, studyUID) {
  const strip = document.getElementById('filmstrip');
  strip.innerHTML = '';

  instances.forEach((uid, i) => {
    const div = document.createElement('div');
    div.className = `film-item ${i === 0 ? 'active-film' : ''}`;
    div.innerHTML = `
      <div style="width:100%;height:100%;background:radial-gradient(ellipse at 50% 50%,#333 0%,#111 70%,#000 100%)"></div>
      <span class="film-num">${i+1}</span>
    `;
    div.onclick = async () => {
      document.querySelectorAll('.film-item').forEach(f => f.classList.remove('active-film'));
      div.classList.add('active-film');
      currentImgIdx = i;
      await loadImage(uid, seriesUID, studyUID);
      document.getElementById('vp-br').textContent  = `Img: ${i+1}/${instances.length}`;
      document.getElementById('bar-img').textContent = `Img ${i+1}/${instances.length}`;
    };
    strip.appendChild(div);
  });
}

// ─── TOOLS ──────────────────────────────────────────────
function setTool(tool, btn) {
  document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  try { cornerstoneTools.setToolActive(tool, { mouseButtonMask: 1 }); } catch(e) {}
}

function invertImage() {
  try {
    const el = document.getElementById('cs-element');
    const vp = cornerstone.getViewport(el);
    vp.invert = !vp.invert;
    cornerstone.setViewport(el, vp);
  } catch(e) {}
}

function resetViewport() {
  try { cornerstone.reset(document.getElementById('cs-element')); } catch(e) {}
}

function applyWWWL() {
  const ww = parseInt(document.getElementById('ww-slider').value);
  const wl = parseInt(document.getElementById('wl-slider').value);
  document.getElementById('ww-display').textContent = ww;
  document.getElementById('wl-display').textContent = wl;
  try {
    const el = document.getElementById('cs-element');
    const vp = cornerstone.getViewport(el);
    vp.voi.windowWidth  = ww;
    vp.voi.windowCenter = wl;
    cornerstone.setViewport(el, vp);
  } catch(e) {}
}

function setPreset(ww, wl) {
  document.getElementById('ww-slider').value = ww;
  document.getElementById('wl-slider').value = wl;
  applyWWWL();
}

function setActiveVp(el) {
  document.querySelectorAll('.viewport').forEach(v => v.classList.remove('active-vp'));
  el.classList.add('active-vp');
}

function setLayout(type, btn) {
  document.getElementById('viewport-grid').className = `viewport-grid ${type}`;
  document.querySelectorAll('.layout-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function filterStudies(q) {
  if (!q) { renderStudies(allStudies); return; }
  const filtered = allStudies.filter(s => {
    const name = (getTag(s,'00100010')||'').toLowerCase();
    const id   = (getTag(s,'00100020')||'').toLowerCase();
    return name.includes(q.toLowerCase()) || id.includes(q.toLowerCase());
  });
  renderStudies(filtered);
}

function refreshStudies() { fetchStudies(); }

// ─── UTILS ──────────────────────────────────────────────
function getTag(obj, tag) {
  if (!obj || !obj[tag]) return null;
  const val = obj[tag];
  if (!val.Value || !val.Value.length) return null;
  const v = val.Value[0];
  if (typeof v === 'string') return v;
  if (v && v.Alphabetic) return v.Alphabetic;
  if (typeof v === 'number') return v.toString();
  return null;
}

function formatDate(d) {
  if (!d || d.length !== 8) return d || '—';
  return `${d.slice(0,4)}-${d.slice(4,6)}-${d.slice(6,8)}`;
}

function getTagClass(mod) {
  const m = (mod||'').toUpperCase();
  if (m.includes('CT')) return 'tag-ct';
  if (m.includes('MR')) return 'tag-mr';
  if (m.includes('CR') || m.includes('DX')) return 'tag-cr';
  if (m.includes('US')) return 'tag-us';
  return 'tag-other';
}

function setOnline() {
  document.getElementById('status-dot').className   = 'status-dot';
  document.getElementById('status-text').textContent = `Orthanc ${ORTHANC.replace('http://','').split(':')[0]}`;
}

function setOffline() {
  document.getElementById('status-dot').className   = 'status-dot offline';
  document.getElementById('status-text').textContent = 'Orthanc Offline';
}

function showToast(msg, icon='ℹ️') {
  const t = document.getElementById('toast');
  document.getElementById('toast-msg').textContent  = msg;
  document.getElementById('toast-icon').textContent = icon;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3500);
}

// ─── START ──────────────────────────────────────────────
fetchStudies();
</script>
</body>
</html>