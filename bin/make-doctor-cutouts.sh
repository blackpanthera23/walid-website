#!/usr/bin/env bash
# Build the doctors' cut-out portraits for the homepage "Talk to us" card (macOS only, no installs).
#   bin/make-doctor-cutouts.sh <dr-walid-source-image> <dr-anis-source-image>
# Background removal uses Apple's on-device Vision framework (bin/cutout.swift, compiled on first run).
# Output: wp-content/themes/walid-child/assets/img/team/{dr-walid,dr-anis}.webp (transparent, 720x900 canvas).
# Crop each source to the person first if the photo has extra elements (e.g. a poster with text).
set -euo pipefail
cd "$(dirname "$0")/.."
[ $# -eq 2 ] || { echo "usage: $0 <dr-walid-image> <dr-anis-image>"; exit 2; }
OUT=wp-content/themes/walid-child/assets/img/team; mkdir -p "$OUT"
BIN=/tmp/walid-cutout
[ -x "$BIN" ] || swiftc -O bin/cutout.swift -o "$BIN"
make() { # <src> <slug>
  local tmp; tmp=$(mktemp -d)
  magick "$1" -auto-orient "$tmp/in.png"
  "$BIN" "$tmp/in.png" "$tmp/cut.png"
  magick "$tmp/cut.png" -trim +repage -resize 720x900 -background none -gravity south -extent 720x900 "$tmp/fit.png"
  cwebp -q 86 -alpha_q 100 -m 6 "$tmp/fit.png" -o "$OUT/$2.webp" >/dev/null
  rm -rf "$tmp"; echo "wrote $OUT/$2.webp"
}
make "$1" dr-walid
make "$2" dr-anis
