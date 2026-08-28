/**
 * Build provincial education-district GeoJSON from the DBE shapefile
 * (OpenUpSA/SA-Maps, EMIS), projected into this app's SVG map frame.
 *
 * Usage:
 *   node scripts/build-education-districts.js
 *   node scripts/build-education-districts.js GT
 */
const fs = require('fs');
const path = require('path');
const https = require('https');

const ROOT = path.join(__dirname, '..');
const DATA = path.join(__dirname, 'data', 'education_districts');
const GEO = path.join(ROOT, 'public', 'geojson');
const SRC = 'https://raw.githubusercontent.com/OpenUpSA/SA-Maps/master/Schools/education_districts/';

const PROVINCES = [
  {
    code: 'GT',
    slug: 'gauteng',
    display: 'Gauteng',
    frameFile: 'gauteng.metros-backup.json',
    districts: [
      d('Gauteng North', ['Gauteng North'], ['GAUTENG NORTH']),
      d('Tshwane North', ['Tshwane North'], ['TSHWANE NORTH']),
      d('Tshwane West', ['Tshwane West'], ['TSHWANE WEST']),
      d('Tshwane South', ['Tshwane South'], ['TSHWANE SOUTH']),
      d('Gauteng West', ['Gauteng West'], ['GAUTENG WEST']),
      d('Johannesburg North', ['Johannesburg North'], ['JOHANNESBURG NORTH']),
      d('Johannesburg West', ['Johannesburg West'], ['JOHANNESBURG WEST']),
      d('Johannesburg Central', ['Johannesburg Central'], ['JOHANNESBURG CENTRAL']),
      d('Johannesburg East', ['Johannesburg East'], ['JOHANNESBURG EAST']),
      d('Johannesburg South', ['Johannesburg South'], ['JOHANNESBURG SOUTH']),
      d('Ekurhuleni North', ['Ekurhuleni North'], ['EKURHULENI NORTH']),
      d('Ekurhuleni South', ['Ekurhuleni South'], ['EKURHULENI SOUTH']),
      d('Gauteng East', ['Gauteng East'], ['GAUTENG EAST']),
      d('Sedibeng West', ['Sedibeng West'], ['SEDIBENG WEST']),
      d('Sedibeng East', ['Sedibeng East'], ['SEDIBENG EAST']),
    ],
  },
  {
    code: 'EC',
    slug: 'easterncape',
    display: 'Eastern Cape',
    frameFile: 'easterncape.municipal-backup.json',
    districts: [
      d('Alfred Nzo East', ['Mt Fletcher', 'Mbizana'], ['ALFRED NZO EAST']),
      d('Alfred Nzo West', ['Maluti', 'Mt Frere'], ['ALFRED NZO WEST']),
      d('Amathole East', ['Butterworth', 'Dutywa'], ['Amathole East']),
      d('Amathole West', ['Fort Beaufort'], ['AMATHOLE WEST']),
      d('Buffalo City', ['East London', 'King Williams Town'], ['BUFFALO CITY']),
      d('Chris Hani East', ['Cofimvaba', 'Ngcobo'], ['CHRIS HANI EAST']),
      d('Chris Hani West', ['Queenstown', 'Lady Frere', 'Cradock'], ['CHRIS HANI WEST']),
      d('Joe Gqabi', ['Sterkspruit'], ['JOE GQABI']),
      d('Nelson Mandela', ['Port Elizabeth', 'Uitenhage'], ['NELSON MANDELA']),
      d('OR Tambo Coastal', ['Lusikisiki', 'Libode'], ['OR TAMBO COASTAL']),
      d('OR Tambo Inland', ['Mthata', 'Qumbu'], ['OR TAMBO INLAND']),
      d('Sarah Baartman', ['Graaff-Reinet', 'Grahamstown'], ['SARAH BAARTMAN']),
    ],
  },
  {
    code: 'FS',
    slug: 'freestate',
    display: 'Free State',
    frameFile: 'freestate.municipal-backup.json',
    districts: [
      d('Fezile Dabi', ['Fezile Dabi'], ['FEZILE DABI']),
      d('Lejweleputswa', ['Lejweleputswa'], ['LEJWELEPUTSWA', 'Letjweleputswa']),
      d('Motheo', ['Motheo'], ['MOTHEO']),
      d('Thabo Mofutsanyana', ['Thabo Mofutsanyana'], ['THABO MOFUTSANYANA']),
      d('Xhariep', ['Xhariep'], ['XHARIEP']),
    ],
  },
  {
    code: 'KZ',
    slug: 'kwazulunatal',
    display: 'KwaZulu-Natal',
    frameFile: 'kwazulunatal.municipal-backup.json',
    districts: [
      d('Amajuba', ['Amajuba'], ['Amajuba']),
      d('Harry Gwala', ['Sisonke'], ['Harry Gwala']),
      d('Ilembe', ['Ilembe'], ['Ilembe']),
      d('King Cetshwayo', ['Empangeni'], ['King Cetshwayo']),
      d('Pinetown', ['Pinetown'], ['Pinetown']),
      d('Ugu', ['Ugu'], ['Ugu']),
      d('Umgungundlovu', ['Umgungundlovu'], ['Umgungundlovu']),
      d('Umkhanyakude', ['Obonjeni'], ['Umkhanyakude']),
      d('Umlazi', ['Umlazi'], ['Umlazi']),
      d('Umzinyathi', ['Umzinyathi'], ['Umzinyathi']),
      d('Uthukela', ['Uthukela'], ['Uthukela']),
      d('Zululand', ['Vryheid'], ['Zululand']),
    ],
  },
  {
    code: 'LP',
    slug: 'limpopo',
    display: 'Limpopo',
    frameFile: 'limpopo.municipal-backup.json',
    districts: [
      d('Capricorn North', ['Polokwane'], ['CAPRICORN NORTH']),
      d('Capricorn South', ['Lebowakgomo'], ['CAPRICORN SOUTH']),
      d('Mogalakwena', ['Mogalakwena'], ['MOGALAKWENA']),
      d('Mopani East', ['Mopani'], ['MOPANI EAST']),
      d('Mopani West', ['Tzaneen'], ['MOPANI WEST']),
      d('Sekhukhune East', ['Riba Cross'], ['SEKHUKHUNE EAST']),
      d('Sekhukhune South', ['Sekhukhune'], ['SEKHUKHUNE SOUTH']),
      d('Vhembe East', ['Vhembe'], ['VHEMBE EAST']),
      d('Vhembe West', ['Tshipise-Sagole'], ['VHEMBE WEST']),
      d('Waterberg', ['Waterberg'], ['WATERBERG']),
    ],
  },
  {
    code: 'MP',
    slug: 'mpumalanga',
    display: 'Mpumalanga',
    frameFile: 'mpumalanga.municipal-backup.json',
    districts: [
      // Bohlabela was later split from Ehlanzeni; the shapefile has the unsplit polygon.
      d('Ehlanzeni', ['Ehlanzeni'], ['EHLANZENI', 'BOHLABELA']),
      d('Gert Sibande', ['Gert Sibande'], ['GERT SIBANDE']),
      d('Nkangala', ['Nkangala'], ['NKANGALA']),
    ],
  },
  {
    code: 'NC',
    slug: 'northerncape',
    display: 'Northern Cape',
    frameFile: 'northerncape.municipal-backup.json',
    districts: [
      d('Frances Baard', ['Frances Baard'], ['FRANCES BAARD (FB)']),
      d('John Taolo Gaetsewe', ['John Taolo Gaetsewe'], ['JOHN TAOLO GAETSEWE (JTG)']),
      d('Namakwa', ['Namakwa'], ['NAMAKWA (NMK)']),
      d('Pixley Ka Seme', ['Pixley-Ka-Seme'], ['PIXLEY KA SEME (PXL)']),
      d('ZF Mgcawu', ['Siyanda'], ['ZF MGCAWU (ZFM)']),
    ],
  },
  {
    code: 'NW',
    slug: 'northwest',
    display: 'North West',
    frameFile: 'northwest.municipal-backup.json',
    districts: [
      d('Bojanala', ['Rustenburg'], ['BOJANALA']),
      d('Dr Kenneth Kaunda', ['Potchefstroom'], ['DR KENNETH KAUNDA']),
      d('Dr Ruth S Mompati', ['Kagisano Molopo'], ['DR RUTH S MOMPATI', 'DR RUTH SEGOMOTSI MOMPATI']),
      d('Ngaka Modiri Molema', ['Mafikeng'], ['NGAKA MODIRI MOLEMA']),
    ],
  },
  {
    code: 'WC',
    slug: 'westerncape',
    display: 'Western Cape',
    frameFile: 'westerncape.municipal-backup.json',
    districts: [
      d('Cape Winelands', ['Cape Winelands'], ['CAPE WINELANDS']),
      d('Eden and Central Karoo', ['Eden and Central Karoo'], ['EDEN AND CENTRAL KAROO']),
      d('Metro Central', ['Metro Central'], ['METRO CENTRAL']),
      d('Metro East', ['Metro East'], ['METRO EAST']),
      d('Metro North', ['Metro North'], ['METRO NORTH']),
      d('Metro South', ['Metro South'], ['METRO SOUTH']),
      d('Overberg', ['Overberg'], ['OVERBERG']),
      d('West Coast', ['West Coast'], ['WEST COAST']),
    ],
  },
];

function d(name, sources, db_names) {
  return { name, sources, db_names };
}

function download(url, dest) {
  return new Promise((resolve, reject) => {
    const file = fs.createWriteStream(dest);
    https.get(url, (res) => {
      if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
        file.close();
        fs.unlinkSync(dest);
        return download(res.headers.location, dest).then(resolve, reject);
      }
      if (res.statusCode !== 200) {
        file.close();
        return reject(new Error('HTTP ' + res.statusCode + ' ' + url));
      }
      res.pipe(file);
      file.on('finish', () => file.close(resolve));
    }).on('error', reject);
  });
}

async function ensureShapefile() {
  fs.mkdirSync(DATA, { recursive: true });
  for (const ext of ['shp', 'shx', 'dbf', 'prj']) {
    const dest = path.join(DATA, 'education_districts.' + ext);
    if (fs.existsSync(dest) && fs.statSync(dest).size > 100) continue;
    process.stdout.write('Downloading education_districts.' + ext + '…\n');
    await download(SRC + 'education_districts.' + ext, dest);
  }
}

function readDbf(buf) {
  const n = buf.readUInt32LE(4);
  const h = buf.readUInt16LE(8);
  const rec = buf.readUInt16LE(10);
  const fields = [];
  let o = 32;
  while (buf[o] !== 0x0d) {
    fields.push({
      name: buf.slice(o, o + 11).toString('ascii').replace(/\0/g, '').trim(),
      len: buf[o + 16],
    });
    o += 32;
  }
  const rows = [];
  for (let i = 0; i < n; i++) {
    const recBuf = buf.slice(h + i * rec, h + (i + 1) * rec);
    let p = 1;
    const row = {};
    for (const f of fields) {
      row[f.name] = recBuf.slice(p, p + f.len).toString('ascii').trim();
      p += f.len;
    }
    rows.push(row);
  }
  return rows;
}

function readShpPolygons(shpBuf, shxBuf) {
  const n = (shxBuf.length - 100) / 8;
  const out = [];
  for (let i = 0; i < n; i++) {
    const offset = shxBuf.readInt32BE(100 + i * 8) * 2;
    let p = offset + 8;
    const type = shpBuf.readInt32LE(p); p += 4;
    if (type !== 5 && type !== 15) {
      out.push([]);
      continue;
    }
    p += 32;
    const numParts = shpBuf.readInt32LE(p); p += 4;
    const numPoints = shpBuf.readInt32LE(p); p += 4;
    const parts = [];
    for (let k = 0; k < numParts; k++) {
      parts.push(shpBuf.readInt32LE(p)); p += 4;
    }
    const pts = [];
    for (let k = 0; k < numPoints; k++) {
      const x = shpBuf.readDoubleLE(p); p += 8;
      const y = shpBuf.readDoubleLE(p); p += 8;
      pts.push([x, y]);
    }
    const rings = [];
    for (let k = 0; k < numParts; k++) {
      const a = parts[k];
      const b = k + 1 < numParts ? parts[k + 1] : numPoints;
      const ring = pts.slice(a, b);
      if (ring.length >= 4) rings.push(ring);
    }
    out.push(rings);
  }
  return out;
}

function bboxOfRings(rings) {
  let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
  for (const ring of rings) {
    for (const [x, y] of ring) {
      if (x < minX) minX = x;
      if (y < minY) minY = y;
      if (x > maxX) maxX = x;
      if (y > maxY) maxY = y;
    }
  }
  return { minX, minY, maxX, maxY, w: maxX - minX, h: maxY - minY };
}

function parsePath(d) {
  const pts = [];
  const re = /(-?\d+\.?\d*)\s+(-?\d+\.?\d*)/g;
  let m;
  while ((m = re.exec(d))) pts.push([parseFloat(m[1]), parseFloat(m[2])]);
  return pts;
}

function distToSeg(p, a, b) {
  const dx = b[0] - a[0], dy = b[1] - a[1];
  const len2 = dx * dx + dy * dy || 1;
  let t = ((p[0] - a[0]) * dx + (p[1] - a[1]) * dy) / len2;
  t = Math.max(0, Math.min(1, t));
  return Math.hypot(p[0] - (a[0] + t * dx), p[1] - (a[1] + t * dy));
}

function simplifyRing(pts, eps) {
  if (pts.length <= 4) return pts;
  const closed = pts.length > 1
    && Math.abs(pts[0][0] - pts[pts.length - 1][0]) < 1e-12
    && Math.abs(pts[0][1] - pts[pts.length - 1][1]) < 1e-12;
  const work = closed ? pts.slice(0, -1) : pts.slice();

  function dp(arr) {
    if (arr.length <= 2) return arr;
    let maxD = -1, idx = 0;
    const a = arr[0], b = arr[arr.length - 1];
    for (let i = 1; i < arr.length - 1; i++) {
      const dist = distToSeg(arr[i], a, b);
      if (dist > maxD) { maxD = dist; idx = i; }
    }
    if (maxD > eps) {
      const left = dp(arr.slice(0, idx + 1));
      const right = dp(arr.slice(idx));
      return left.slice(0, -1).concat(right);
    }
    return [a, b];
  }

  const simple = dp(work);
  if (simple.length && (simple[0][0] !== simple[simple.length - 1][0]
      || simple[0][1] !== simple[simple.length - 1][1])) {
    simple.push(simple[0].slice());
  }
  return simple.length >= 4 ? simple : pts;
}

function ringArea(pts) {
  let a = 0;
  for (let i = 0; i < pts.length - 1; i++) {
    a += pts[i][0] * pts[i + 1][1] - pts[i + 1][0] * pts[i][1];
  }
  return a / 2;
}

function centroidOfRings(rings) {
  let best = rings[0], bestA = 0;
  for (const ring of rings) {
    const a = Math.abs(ringArea(ring));
    if (a > bestA) { bestA = a; best = ring; }
  }
  let x = 0, y = 0, n = 0;
  for (const p of best) { x += p[0]; y += p[1]; n++; }
  return { x: x / n, y: y / n };
}

function toPath(rings) {
  return rings.map((ring) => {
    const pts = ring.slice();
    if (pts.length > 1) {
      const a = pts[0], b = pts[pts.length - 1];
      if (Math.abs(a[0] - b[0]) < 1e-9 && Math.abs(a[1] - b[1]) < 1e-9) pts.pop();
    }
    return 'M ' + pts.map((p) => p[0].toFixed(4) + ' ' + p[1].toFixed(4)).join(' ') + ' Z';
  }).join(' ');
}

function ensureFrame(prov) {
  const framePath = path.join(GEO, prov.frameFile);
  const currentPath = path.join(GEO, prov.slug + '.json');
  if (fs.existsSync(framePath) && fs.statSync(framePath).size > 50) return framePath;
  if (!fs.existsSync(currentPath)) {
    throw new Error('Missing SVG frame for ' + prov.slug + ': ' + prov.frameFile);
  }
  fs.copyFileSync(currentPath, framePath);
  console.log('Backed up', prov.slug + '.json →', prov.frameFile);
  return framePath;
}

function indexProvinceRings(dbf, ringsList, code) {
  const byName = {};
  dbf.forEach((row, i) => {
    if (row.PROVINCE !== code) return;
    byName[row.ED_DISTRIC] = ringsList[i] || [];
  });
  return byName;
}

function buildProvince(prov, byName) {
  const missing = [];
  for (const dist of prov.districts) {
    for (const src of dist.sources) {
      if (!byName[src] || !byName[src].length) missing.push(src);
    }
  }
  if (missing.length) {
    throw new Error(
      prov.display + ' missing DBE polygons: ' + missing.join(', ')
      + '\nHave: ' + Object.keys(byName).join(', ')
    );
  }

  const allRings = prov.districts.flatMap((dist) => dist.sources.flatMap((src) => byName[src]));
  const wgs = bboxOfRings(allRings);
  if (!wgs.w || !wgs.h) throw new Error('Empty WGS bbox for ' + prov.display);

  const frame = JSON.parse(fs.readFileSync(ensureFrame(prov), 'utf8'));
  const framePts = frame.flatMap((m) => parsePath(m.path));
  const svg = bboxOfRings([framePts]);
  if (!svg.w || !svg.h) throw new Error('Empty SVG frame bbox for ' + prov.display);

  function toSvg(lon, lat) {
    return [
      svg.minX + ((lon - wgs.minX) / wgs.w) * svg.w,
      svg.minY + ((wgs.maxY - lat) / wgs.h) * svg.h,
    ];
  }

  return prov.districts.map((dist) => {
    const svgRings = dist.sources
      .flatMap((src) => byName[src])
      .map((ring) => simplifyRing(ring.map(([lon, lat]) => toSvg(lon, lat)), 0.12))
      .filter((ring) => ring.length >= 4);
    if (!svgRings.length) {
      throw new Error('No projected rings for ' + dist.name);
    }
    const c = centroidOfRings(svgRings);
    return {
      name: dist.name,
      path: toPath(svgRings),
      color: '#99b871',
      province: prov.display,
      db_names: dist.db_names.slice(),
      label_x: +c.x.toFixed(3),
      label_y: +c.y.toFixed(3),
    };
  });
}

async function main(onlyCode) {
  await ensureShapefile();

  const dbf = readDbf(fs.readFileSync(path.join(DATA, 'education_districts.dbf')));
  const ringsList = readShpPolygons(
    fs.readFileSync(path.join(DATA, 'education_districts.shp')),
    fs.readFileSync(path.join(DATA, 'education_districts.shx'))
  );

  const want = onlyCode
    ? PROVINCES.filter((p) => p.code === String(onlyCode).toUpperCase())
    : PROVINCES;
  if (!want.length) {
    throw new Error('Unknown province code: ' + onlyCode);
  }

  for (const prov of want) {
    const byName = indexProvinceRings(dbf, ringsList, prov.code);
    const final = buildProvince(prov, byName);
    const out = path.join(GEO, prov.slug + '.education.json');
    fs.writeFileSync(out, JSON.stringify(final));
    console.log('\n' + prov.display + ' → ' + prov.slug + '.education.json (' + final.length + ' districts)');
    final.forEach((r) => {
      const pts = (r.path.match(/-?\d+\.?\d*/g) || []).length / 2;
      console.log(' -', r.name.padEnd(26), 'pts=' + String(Math.round(pts)).padStart(4), 'db=' + r.db_names.join('|'));
    });
  }
}

if (require.main === module) {
  main(process.argv[2]).catch((err) => {
    console.error(err);
    process.exit(1);
  });
}

module.exports = { main, PROVINCES };
