# Higgsfield VIDEO Guide — Walid Homepage Hero (for OMP)

**Compiled:** 2026-10-31 by Kiro · **Owner:** Akmal · **Client:** Poliklinik Walid
**Surface:** Higgsfield MCP · **Scope:** ONE homepage hero ambient loop · **Budget:** Starter credits, one-project spend.

> Operating guide, not an authorization to spend. Every paid call needs Akmal's explicit "ok go" after
> the cost gate (Section 6). The MCP endpoint/tool names are unverified in the Hermes notes — confirm the
> live server and the live per-generation price before any call.

---

## 1. Read this first — should we even generate a video?

The homepage hero motion is **already solved for free** with CSS (concepts A·v2 + B·v2, live in the
theme). That CSS motion is crisp at any resolution, loops perfectly, weighs nothing, and reads
calm-clinical. A generated clip is **optional** and only worth credits if Akmal wants a richer,
filmed-looking backdrop that CSS can't match.

Two hard realities before spending:
- **Starter caps video at 720p** (Seedance 2.5 / Veo / Kling 1080p are Plus/Ultra only).
- **Cost is unconfirmed and can be high.** The Hermes `design-pack/07-ai-generation.md` records 6 images
  reported at **800 credits**, with the warning that "subscription = MCP unlimited" cannot be assumed.
  One video costs more than one image. A single hero loop with retries could consume most of ~200
  credits. If the live price is unknown at call time, **STOP** before spending.

### DECISION (2026-11-01): do NOT generate a hero video.
This was tested and reverted. OMP generated a plate (2 cr) + a MiniMax H3 clip (10 cr) = 12 credits
for a loop that (a) the CSS hero already replaces for free, (b) Akmal rejected ("hero loop mengarut"),
and (c) did not loop seamlessly (frame 0 vs last frame differed 1.41%; pinning start=end did not fix
it on the live models). **The homepage hero stays on the free CSS motion.** The rest of this guide is
kept only as reference if a video is ever reconsidered — it is NOT a to-do.

### Live-model reality (verified 2026-11-01, corrects earlier drafts)
- **4:5 is NOT supported by any available model.** Observed: kling3_0 = 16:9 / 9:16 / 1:1;
  seedance_2_0 and minimax_h3 = 4:3 / 3:4 / 1:1; veo3_1 = 16:9 / 9:16 only.
  The nearest portrait ratio is **3:4** (use that, then crop, if ever generating).
- **Real costs are higher than the old ~7.5-credit estimate:** MiniMax H3 (3:4) cost **10 credits** per
  attempt; Seedance (closest to the intended look) is about **22.5 credits**. Budget accordingly.
- MiniMax H3 output carried an **AAC audio track** and ~5.2s / 24fps, not the requested 8s/30fps/silent.
  Any kept clip must be stripped to silent and retimed in ffmpeg.

---

## 2. The rule that shapes this video (brand + ethics)

Poliklinik Walid is a **real surgeon-led clinic with real doctors** (Dr Walid, Dr Anis), proof-first brand.
The hero video is **abstract ambient brand motion ONLY**:
- **NO people, NO faces, NO patients, NO doctors.** Generating a fake clinic or fake people for a real
  medical brand misrepresents the practice and breaks the no-fake-proof rule.
- **NO text, numbers, logos, blood, wounds, needles, or instruments** in the frame. Text/stats live in HTML.
- **NO claims.** The clip sets a calm, premium mood and nothing more.
- It is the moving version of the existing hero panel: organic navy shapes + a warm gold light + a few
  floating dots (the AB / Prototype 3 look).

Real procedure footage already exists at `~/.hermes/drwalid-videos/` (real Magnific-upscaled clips of
xanthelasma/lipoma/ketuat, 540×960 vertical) — that is for procedure pages, costs zero, do not regenerate.

---

## 3. Healthcare motion language (what to prompt, what to avoid)

Even fintech sites (checked: PinjamNow.my) ship calm, content-tied motion — no particles, no network
lines, no glowing orbs. For a clinic the bar is higher.

**Never prompt (reads tech / breaks brand):**
```
dots connected by lines / constellation / network / nodes     (reads AI/data)
glowing orbs, mix-blend screen, neon, bloom                    (reads startup)
fast moving gradient sweeps, RGB shift, glitch                 (reads tech)
orbit / drone rise / whip pan / dolly zoom / handheld          (reads AI video)
any face, patient, doctor, body, wound, instrument, blood      (brand + ethics ban)
text, numbers, logos in the frame                              (added later in HTML)
teal-and-orange grade, lens flare, slow-motion ramp            (AI-stock tells)
```

**Positive vocabulary (reads premium clinic):**
```
soft daylight · calm · airy negative space · organic rounded forms · gentle breathing motion ·
matte navy #232B8F · warm gold #C9A227 light · subtle depth · unhurried · reassuring · editorial
```

---

## 4. The two-step pipeline (plate first, then animate)

The gold rule from the Hermes catalog: *if the base image looks AI, nothing downstream saves it.* So
generate and APPROVE the still plate before spending one credit on video.

### STEP 1 — the plate (image · Nano Banana Pro · 4:5 portrait · ~2 credits)
```
=======
POLIKLINIK WALID — HERO AMBIENT PLATE — v1
Original abstract artwork. No people, no text, no logos.
=======
--- LOCKED — DO NOT EDIT ---
FORMAT: portrait 4:5, 1600 x 2000 px, full-bleed, fully opaque.
STYLE: premium healthcare, calm and airy. Soft organic rounded shapes layered with gentle depth,
warm daylight from the upper right, generous negative space. Matte, editorial. Not clinical, not
anxious, not glossy, not cartoonish, not photoreal, not a diagram.
PALETTE: deep royal navy #232B8F dominant in a soft gradient, warm gold #C9A227 as a single light
accent under 12%, soft green #1E8E66 barely present, warm off-white space.
MOOD: unhurried, trustworthy, like calm morning light in a modern clinic.
--- SUBJECT ---
Three or four softly overlapping organic rounded shapes in navy tones with a gentle gold light on
one edge, a few small floating dots, resting in airy negative space with soft depth of field.
--- MUST HOLD (reject the output if any appear) ---
No faces/people/body parts, no text/numbers/logos, no connecting lines, no network, no glow,
no blood/wounds/instruments, no blue-purple gradient, no glassmorphism, no lens flare.
Navy dominant, gold is a light accent only.
```

### STEP 2 — animate the approved plate (video · Seedance/Veo · one attempt at a time)
```
@hero_plate  The soft organic navy shapes breathe slowly and drift a few pixels while a warm gold
light glides gently across one edge and a few small dots float upward through the airy space.
CAMERA: static, locked off. Internal motion only. No pan, no orbit, no zoom, no dolly.
STYLE: premium healthcare brand motion, calm, soft daylight, matte, matching #232B8F navy and
#C9A227 gold.
LIGHTING: warm diffused daylight from upper right, soft and even.
TECH: 4:5 portrait, 30fps, 8s, seamless loop (start frame = end frame), silent, no audio.
--- MOTION GUARD (keep verbatim) ---
Calm healthcare brand motion throughout — slow gentle breathing drift, no camera movement, no
people, no text, no network lines, no fast motion, no flashing. Warm daylight. Smooth 30fps.
Loops seamlessly. Animation must start at the first frame.
```

### Alternative — wide background band instead of the hero panel (16:9)
```
Reuse the LOCKED block, change FORMAT to: landscape 16:9, 1920 x 1080 px.
SUBJECT: a wide calm navy field with two or three large soft organic shapes overlapping off the
edges, one warm gold light low on the right, deep airy negative space in the centre for a headline.
VIDEO ACTION: shapes breathe and drift very slowly; the gold light pulses once every several
seconds like a slow, quiet heartbeat; a few dots drift upward; the centre stays calm and uncluttered.
+ same MOTION GUARD.
```

---

## 5. Technical spec for the final asset
```
Aspect / size : 4:5 is UNAVAILABLE on live models. Use 3:4 (nearest portrait) and center-crop to the
                hero panel, or 16:9 for a wide band. 1200 x 1500 px target after crop.
Duration      : 8-10 seconds, loops clean. (Models may output ~5s/24fps — retime in ffmpeg.)
Frame rate    : 30 fps.    Audio: none (strip any AAC track the model adds with ffmpeg -an).
Output        : MP4 (H.264) + optional WebM sibling + a WebP/JPG poster from frame 1.
File size     : MP4 well under ~1.5 MB (hero loads eager). Compress with ffmpeg.
Filenames     : hero-loop.mp4 · hero-loop.webm · hero-poster.webp
Destination   : wp-content/themes/walid-child/assets/video/
```
Loop seam fix: regenerate with the plate pinned as both start and end frame, or crossfade the last
~0.5s onto the first in ffmpeg.

---

## 6. Cost gate (BINDING — do not skip)

Before ANY paid call, send Akmal this and wait for an explicit "ok go":
```
Nak generate: hero loop video untuk homepage Walid.
Plate: Nano Banana Pro · 1 output · 4:5 · ~2 credit.
Video: [model] · 720p · ~[n] credit setiap cuba · budget [n] cuba = [n] credit.
Jumlah ceiling: [n] credit. Baki selepas: ~[n].
Nota: harga MCP sebenar kena baca live dulu (log lama: 6 imej = 800 credit). CSS hero percuma dah ada.
Ok go?
```
Rules: list project history first (free); never test the connection with a generation; if the price is
unknown, STOP; old approvals do not carry; Magnific stays stopped without its own per-job permission.

---

## 7. MCP call sequence (how OMP runs it)
```
1. List project/history (free) — confirm MCP connected + read balance + live per-gen price.
2. Generate the PLATE (Step 1). Download, inspect against MUST HOLD. Approve or fix the prompt.
3. Only after plate approved: generate the VIDEO (Step 2), one attempt at a time.
4. Download + ffprobe every output (real dimensions, duration, fps, no audio). Watch it loop.
   "Completed" status is NOT proof it meets the brief.
5. Compress to target size, export poster from frame 1, place files in assets/video/.
6. Record the job URL + reported credit cost for each generation.
```

---

## 8. Tuning levers (change ONE at a time, max two correction rounds)
```
too fast                 -> "very slow, barely perceptible drift", duration 10s
loop seam visible        -> pin start frame as end frame, or ffmpeg crossfade
reads tech / sci-fi      -> remove the dots, keep only breathing shapes
too cold / corporate     -> add "warm morning daylight", lift the gold light slightly
looks like AI stock      -> drop any camera motion entirely, internal motion only
gold looks cheap/yellow  -> "muted antique gold #C9A227, as light not as fill"
looks like a diagram     -> "soft painterly gradients, no outlines, no flat vector"
```
If the output is still wrong after two rounds, the PLATE is the problem — fix the plate, do not buy
more video rerolls.

---

## 9. Already wired in the theme (no code needed after generating)

`walid_hero_video()` auto-detects `assets/video/hero-loop.mp4`. When present, the hero renders a muted,
looping, playsinline `<video>` inside the organic panel with the floating dots on top, and shows the
poster frame under `prefers-reduced-motion`. Drop the files in and the hero video goes live. If no video
exists, the hero falls back to the CSS motion + placeholder image.

---

## 10. Acceptance gate (before calling it done)
```
- File ffprobed: 4:5 (or cropped to it), 8-10s, 30fps, NO audio, under ~1.5 MB.
- Loops with no visible seam. No people/text/gore anywhere. Navy dominant, gold accent.
- Looks filmed/premium, not AI-stock. If not: fix the PLATE, not the video.
- Poster frame exists, matches frame 1.
- Files in assets/video/ as hero-loop.mp4 / .webm / hero-poster.webp.
- Hero shows the loop on desktop + mobile; poster shows under reduced-motion.
  Check: docker compose up -d, open http://localhost:8080.
- Cost log recorded: job URLs + reported credits.
```

---

## 11. Status (resolved 2026-11-01)
```
1. Video or free CSS hero?  -> RESOLVED: free CSS hero. No video. (Tested + reverted, 12 cr spent.)
2. 4:5 format?              -> RESOLVED: unavailable. 3:4 is the nearest if ever revisited.
3. Real cost?              -> RESOLVED: MiniMax H3 = 10 cr/attempt; Seedance ~22.5 cr. Not ~7.5.
4. Audio/duration?         -> Models add AAC and run ~5s/24fps; strip + retime in ffmpeg if kept.
```
This guide is now reference-only for video. The live hero is CSS. Do not regenerate a hero video
without a fresh, explicit instruction from Akmal.

---
*Image assets (pillar textures, clinic ambience, procedure illustrations) are covered separately in
`docs/HIGGSFIELD-OMP-GUIDE.md`. This file is the single source of truth for VIDEO.*
