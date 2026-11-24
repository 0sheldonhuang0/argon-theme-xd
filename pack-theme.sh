#!/usr/bin/env bash
# 生成可直接在 WordPress 后台安装的完整运行包。
# 只排除 Git、预览、源码和 source map；主题运行时资源全部保留。

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SLUG="argon-theme-xd"
OUT_DIR="$ROOT/dist"
OUT="$OUT_DIR/$SLUG.zip"

EXCLUDES=(
	--exclude '/.git/'
	--exclude '/.github/'
	--exclude '/.workbuddy/'
	--exclude '/_preview/'
	--exclude '/dist/'
	--exclude '/node_modules/'
	--exclude '/assets/scss/'
	--exclude '/gutenberg/src/'
	--exclude '/gutenberg/package.json'
	--exclude '/gutenberg/package-lock.json'
	--exclude '/pack-theme.sh'
	--exclude '/.gitignore'
	--exclude '/.gitattributes'
	--exclude '.DS_Store'
	--exclude '*.map'
	--exclude '*.log'
)

REQUIRED_FILES=(
	style.css
	functions.php
	index.php
	front-page.php
	header.php
	footer.php
	argontheme.js
	assets/argon_css_merged.css
	assets/argon_js_merged.js
	assets/css/argon.min.css
	assets/css/site-chrome.css
	assets/css/site-content.css
	assets/css/front-page.css
	assets/js/argon.min.js
	assets/vendor/jquery/jquery.min.js
	assets/vendor/bootstrap/bootstrap.min.js
	assets/vendor/nucleo/css/nucleo.css
	assets/vendor/font-awesome/css/font-awesome.min.css
	assets/vendor/smoothscroll/smoothscroll1.js
	assets/vendor/smoothscroll/smoothscroll1_pulse.js
	assets/vendor/smoothscroll/smoothscroll2.js
	assets/vendor/smoothscroll/smoothscroll3.min.js
	assets/vendor/highlight/highlight.pack.js
	gutenberg/dist/blocks.build.js
	gutenberg/dist/blocks.editor.build.css
	gutenberg/dist/blocks.style.build.css
)

stage="$(mktemp -d)"
trap 'rm -rf "$stage"' EXIT
mkdir -p "$stage/$SLUG" "$OUT_DIR"

rsync -a "${EXCLUDES[@]}" "$ROOT/" "$stage/$SLUG/"

# 后台主题缩略图无需保留 1920px；只压缩展示资源，不删除功能文件。
if [ -f "$stage/$SLUG/screenshot.png" ] && command -v sips >/dev/null 2>&1; then
	sips -Z 880 "$stage/$SLUG/screenshot.png" --out "$stage/$SLUG/screenshot.png" >/dev/null 2>&1 || true
fi

for file in "${REQUIRED_FILES[@]}"; do
	if [ ! -s "$stage/$SLUG/$file" ]; then
		echo "打包中止：缺少运行文件 $file" >&2
		exit 1
	fi
done

rm -f "$OUT"
(cd "$stage" && zip -r -X -q -9 "$OUT" "$SLUG")

# 再检查一次 zip 本身，防止排除规则误伤嵌套目录（例如 gutenberg/dist）。
zip_entries="$(unzip -Z1 "$OUT")"
for file in "${REQUIRED_FILES[@]}"; do
	if ! grep -Fqx "$SLUG/$file" <<< "$zip_entries"; then
		echo "打包校验失败：压缩包内缺少 $file" >&2
		exit 1
	fi
done

bytes="$(wc -c < "$OUT" | tr -d ' ')"
count="$(unzip -Z1 "$OUT" | wc -l | tr -d ' ')"
size_mb="$(awk -v bytes="$bytes" 'BEGIN { printf "%.2f", bytes / 1048576 }')"

printf '已生成：%s\n体积：%s MB（%s 个文件）\n' "$OUT" "$size_mb" "$count"
