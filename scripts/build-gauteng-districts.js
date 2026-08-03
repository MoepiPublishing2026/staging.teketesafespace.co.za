/**
 * Build granular Gauteng districts by clipping REAL metro SVG outlines.
 * Outer boundaries stay geographic; exclusive partitions get organic cut edges
 * so interior districts don't look like boxes/octagons.
 */
const fs = require('fs');
const path = require('path');

const BACKUP = path.join(__dirname, '../public/geojson/gauteng.metros-backup.json');
const OUT = path.join(__dirname, '../public/geojson/gauteng.json');

function parsePath(d) {
  const pts = [];
  const re = /(-?\d+\.?\d*)\s+(-?\d+\.?\d*)/g;
  let m;
  while ((m = re.exec(d))) pts.push([parseFloat(m[1]), parseFloat(m[2])]);
  if (pts.length > 1) {
    const a = pts[0], b = pts[pts.length - 1];
    if (Math.abs(a[0] - b[0]) < 1e-6 && Math.abs(a[1] - b[1]) < 1e-6) pts.pop();
  }
  return pts;
}

function toPath(ring) {
  if (!ring || ring.length < 3) return '';
  return 'M ' + ring.map((p) => p[0].toFixed(4) + ' ' + p[1].toFixed(4)).join(' ') + ' Z';
}

function bbox(pts) {
  let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
  for (const [x, y] of pts) {
    if (x < minX) minX = x;
    if (y < minY) minY = y;
    if (x > maxX) maxX = x;
    if (y > maxY) maxY = y;
  }
  return { minX, minY, maxX, maxY, w: maxX - minX, h: maxY - minY };
}

function centroid(pts) {
  let x = 0, y = 0;
  for (const p of pts) { x += p[0]; y += p[1]; }
  return { x: x / pts.length, y: y / pts.length };
}

function nearParent(p, parentPts, eps = 0.12) {
  for (let i = 0; i < parentPts.length; i++) {
    const a = parentPts[i];
    const b = parentPts[(i + 1) % parentPts.length];
    const dx = b[0] - a[0], dy = b[1] - a[1];
    const len2 = dx * dx + dy * dy || 1;
    let t = ((p[0] - a[0]) * dx + (p[1] - a[1]) * dy) / len2;
    t = Math.max(0, Math.min(1, t));
    const px = a[0] + t * dx, py = a[1] + t * dy;
    if (Math.hypot(p[0] - px, p[1] - py) <= eps) return true;
  }
  return false;
}

/** Wave only artificial cut edges; keep real metro coastline points intact. */
function organicizeCuts(clipped, parentPts, minLen = 0.55, samples = 24, amp = 0.65) {
  const out = [];
  for (let i = 0; i < clipped.length; i++) {
    const a = clipped[i];
    const b = clipped[(i + 1) % clipped.length];
    out.push(a);
    const len = Math.hypot(b[0] - a[0], b[1] - a[1]);
    if (len < minLen) continue;
    const aOn = nearParent(a, parentPts, 0.15);
    const bOn = nearParent(b, parentPts, 0.15);
    if (aOn && bOn) continue; // keep original geographic edge
    const nx = -(b[1] - a[1]) / len;
    const ny = (b[0] - a[0]) / len;
    const waves = 2.2 + (i % 4) * 0.45;
    for (let s = 1; s < samples; s++) {
      const t = s / samples;
      const wave = Math.sin(t * Math.PI * waves) * amp * Math.sin(t * Math.PI);
      out.push([
        a[0] + (b[0] - a[0]) * t + nx * wave,
        a[1] + (b[1] - a[1]) * t + ny * wave,
      ]);
    }
  }
  return out;
}

function intersect(a, b, x0, y0, x1, y1) {
  const dx = b[0] - a[0], dy = b[1] - a[1];
  const lx = x1 - x0, ly = y1 - y0;
  const den = dx * ly - dy * lx;
  if (Math.abs(den) < 1e-12) return a.slice();
  const t = ((x0 - a[0]) * ly - (y0 - a[1]) * lx) / den;
  return [a[0] + t * dx, a[1] + t * dy];
}

function clipEdge(poly, x0, y0, x1, y1, insideFn) {
  if (!poly.length) return [];
  const out = [];
  for (let i = 0; i < poly.length; i++) {
    const cur = poly[i];
    const prev = poly[(i + poly.length - 1) % poly.length];
    const curIn = insideFn(cur[0], cur[1]);
    const prevIn = insideFn(prev[0], prev[1]);
    if (curIn) {
      if (!prevIn) out.push(intersect(prev, cur, x0, y0, x1, y1));
      out.push(cur);
    } else if (prevIn) {
      out.push(intersect(prev, cur, x0, y0, x1, y1));
    }
  }
  return out;
}

function clipRect(poly, rx0, ry0, rx1, ry1) {
  let p = poly.slice();
  p = clipEdge(p, rx0, ry0, rx1, ry0, (x, y) => y >= ry0);
  p = clipEdge(p, rx1, ry0, rx1, ry1, (x, y) => x <= rx1);
  p = clipEdge(p, rx1, ry1, rx0, ry1, (x, y) => y <= ry1);
  p = clipEdge(p, rx0, ry1, rx0, ry0, (x, y) => x >= rx0);
  return p;
}

function splitParent(parentPts, pieces) {
  const b = bbox(parentPts);
  const out = [];
  for (const piece of pieces) {
    const rx0 = b.minX + piece.x0 * b.w;
    const ry0 = b.minY + piece.y0 * b.h;
    const rx1 = b.minX + piece.x1 * b.w;
    const ry1 = b.minY + piece.y1 * b.h;
    // Exact shared clip edges (no independent waving) — avoids white gap slices.
    let clipped = clipRect(parentPts, rx0, ry0, rx1, ry1);
    if (!clipped || clipped.length < 3) {
      console.warn('Empty clip:', piece.name);
      continue;
    }
    const cb = bbox(clipped);
    if (cb.w < 0.3 || cb.h < 0.3) {
      console.warn('Tiny clip:', piece.name);
      continue;
    }
    const c = centroid(clipped);
    out.push({
      name: piece.name,
      path: toPath(clipped),
      color: '#99b871',
      province: 'Gauteng',
      db_names: piece.db,
      label_x: c.x,
      label_y: c.y,
    });
  }
  return out;
}

const metros = JSON.parse(fs.readFileSync(BACKUP, 'utf8'));
const byName = {};
for (const m of metros) byName[m.name.toLowerCase()] = parsePath(m.path);

const tshwane = byName['city of tshwane'];
const jhb = byName['city of johannesburg'];
const eku = byName['city of ekhurhuleni'];
const sed = byName['sedibeng'];
const wr = byName['west rand'];

if (!tshwane || !jhb || !eku || !sed || !wr) {
  console.error('Missing metro', Object.keys(byName));
  process.exit(1);
}

const regions = [];

regions.push(...splitParent(tshwane, [
  { name: 'Gauteng North', x0: 0.28, y0: 0.00, x1: 1.00, y1: 0.20, db: ['GAUTENG NORTH'] },
  { name: 'Tshwane North', x0: 0.22, y0: 0.20, x1: 0.78, y1: 0.42, db: ['TSHWANE NORTH'] },
  { name: 'Tshwane Metro (Pretoria)', x0: 0.18, y0: 0.42, x1: 0.72, y1: 0.68, db: ['TSHWANE WEST'] },
  { name: 'Tshwane South', x0: 0.22, y0: 0.68, x1: 0.78, y1: 1.00, db: ['TSHWANE SOUTH'] },
  { name: 'Gauteng East', x0: 0.72, y0: 0.18, x1: 1.00, y1: 0.85, db: ['GAUTENG EAST'] },
]));

regions.push(...splitParent(wr, [
  { name: 'West Rand Region', x0: 0.00, y0: 0.00, x1: 1.00, y1: 0.48, db: ['GAUTENG WEST'] },
  { name: 'Gauteng West', x0: 0.00, y0: 0.48, x1: 1.00, y1: 1.00, db: ['GAUTENG WEST'] },
]));

regions.push(...splitParent(jhb, [
  { name: 'Johannesburg North', x0: 0.00, y0: 0.00, x1: 1.00, y1: 0.28, db: ['JOHANNESBURG NORTH'] },
  { name: 'Johannesburg West', x0: 0.00, y0: 0.28, x1: 0.34, y1: 0.70, db: ['JOHANNESBURG WEST'] },
  { name: 'Johannesburg Central', x0: 0.34, y0: 0.28, x1: 0.66, y1: 0.70, db: ['JOHANNESBURG CENTRAL'] },
  { name: 'Johannesburg East', x0: 0.66, y0: 0.28, x1: 1.00, y1: 0.70, db: ['JOHANNESBURG EAST'] },
  { name: 'Johannesburg South', x0: 0.00, y0: 0.70, x1: 1.00, y1: 1.00, db: ['JOHANNESBURG SOUTH'] },
]));

regions.push(...splitParent(eku, [
  { name: 'Ekurhuleni North', x0: 0.00, y0: 0.00, x1: 1.00, y1: 0.34, db: ['EKURHULENI NORTH'] },
  { name: 'Ekurhuleni Metro', x0: 0.00, y0: 0.34, x1: 1.00, y1: 0.66, db: ['EKURHULENI NORTH', 'EKURHULENI SOUTH'] },
  { name: 'Ekurhuleni South', x0: 0.00, y0: 0.66, x1: 1.00, y1: 1.00, db: ['EKURHULENI SOUTH'] },
]));

regions.push(...splitParent(sed, [
  { name: 'Sedibeng West', x0: 0.00, y0: 0.00, x1: 0.34, y1: 1.00, db: ['SEDIBENG WEST'] },
  { name: 'Sedibeng Region (Vaal Triangle)', x0: 0.34, y0: 0.00, x1: 0.66, y1: 1.00, db: ['SEDIBENG WEST', 'SEDIBENG EAST'] },
  { name: 'Sedibeng East', x0: 0.66, y0: 0.00, x1: 1.00, y1: 1.00, db: ['SEDIBENG EAST'] },
]));

const expected = [
  'Gauteng North', 'Tshwane North', 'Tshwane Metro (Pretoria)', 'Tshwane South',
  'West Rand Region', 'Gauteng West',
  'Johannesburg North', 'Johannesburg West', 'Johannesburg Central', 'Johannesburg East', 'Johannesburg South',
  'Ekurhuleni North', 'Ekurhuleni Metro', 'Ekurhuleni South', 'Gauteng East',
  'Sedibeng West', 'Sedibeng Region (Vaal Triangle)', 'Sedibeng East',
];

const byDistrict = {};
for (const r of regions) byDistrict[r.name] = r;

const missing = expected.filter((n) => !byDistrict[n]);
if (missing.length) {
  console.error('Missing:', missing.join(', '));
  process.exit(1);
}

const final = expected.map((n) => {
  const r = byDistrict[n];
  return {
    name: r.name,
    path: r.path,
    color: r.color,
    province: r.province,
    db_names: r.db_names,
    label_x: +r.label_x.toFixed(3),
    label_y: +r.label_y.toFixed(3),
  };
});

fs.writeFileSync(OUT, JSON.stringify(final));
console.log('Wrote', final.length, 'realistic clipped districts');
final.forEach((r) => {
  const pts = (r.path.match(/-?\d+\.?\d*/g) || []).length / 2;
  console.log(' -', r.name.padEnd(40), 'pts=' + Math.round(pts));
});
