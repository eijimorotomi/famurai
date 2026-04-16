# Famurai デモサイト — Claude Code コンテキスト

## セッション開始手順

> このファイルを読んだら、次に以下のファイルを読んでタスクを確認してください。
> パス: ~/Documents/Obsidian Vault/projects/famurai-demo/tasks.md
>
> - 「作業中」のタスクがあればそこから着手する
> - タスク完了時は tasks.md のチェックボックスを更新する

---

## プロジェクト概要

- **サイト名**: Famurai（ファムライ）— 架空の音楽機材・オーディオ輸入代理店
- **目的**: クライアント（完実電気・銀座十字屋）向け提案用デモサイト
- **ローカルURL**: http://famurai.local
- **管理画面**: http://famurai.local/wp-admin（admin / admin1234）
- **データベースマネージャー**: DevKinsta → 「データベースマネージャー」ボタン
- **リモート（Kinsta）**: DevKinsta → 「同期 → Staging にプッシュ」

---

## 開発環境

### 構成（DevKinsta）

| 役割 | 詳細 |
|------|------|
| ローカル環境 | DevKinsta |
| サイトファイル | `~/DevKinsta/public/famurai/` |
| wp-content | `~/DevKinsta/public/famurai/wp-content/` |
| コンテナ | devkinsta_fpm / devkinsta_db / devkinsta_nginx |
| Kinsta デプロイ | DevKinsta → 同期 → Staging にプッシュ |

> ⚠️ 旧 Docker 環境（famurai-demo）は**使用停止**。
> `~/Projects/famurai-demo/` は Git 管理用として残すが、開発作業は DevKinsta で行う。

---

## WP-CLI の使い方

### ローカル（DevKinsta）

```bash
# 書式
docker exec devkinsta_fpm wp --path=/www/kinsta/public/famurai --allow-root <コマンド>

# キャッシュクリア
docker exec devkinsta_fpm wp --path=/www/kinsta/public/famurai --allow-root cache flush

# プラグイン確認
docker exec devkinsta_fpm wp --path=/www/kinsta/public/famurai --allow-root plugin list --status=active

# テーマ確認
docker exec devkinsta_fpm wp --path=/www/kinsta/public/famurai --allow-root theme list --status=active

# パーマリンク再生成
docker exec devkinsta_fpm wp --path=/www/kinsta/public/famurai --allow-root rewrite flush

# コンテナに入る
docker exec -it devkinsta_fpm bash
```

### リモート（Kinsta ステージング）

```bash
# 接続情報
# Host: 140.83.62.102  Port: 61241  User: famurai
# WP パス: /www/famurai_375/public
# URL: http://stg-famurai-staging.kinsta.cloud

# WP-CLI 書式
ssh famurai@140.83.62.102 -p 61241 "wp --path=/www/famurai_375/public <コマンド>"

# キャッシュクリア
ssh famurai@140.83.62.102 -p 61241 "wp --path=/www/famurai_375/public cache flush"

# WP-CLI スクリプト実行
scp -P 61241 setup-script.php famurai@140.83.62.102:/www/famurai_375/public/
ssh famurai@140.83.62.102 -p 61241 "wp --path=/www/famurai_375/public eval-file /www/famurai_375/public/setup-script.php && rm /www/famurai_375/public/setup-script.php"
```

### ファイル転送（ローカル → ステージング）

> ローカルで編集後、scp で特定ファイルのみステージングに転送する。
> DevKinsta の Push to Staging は DB ごと上書きするため使用禁止。

```bash
# ショートハンド変数（参考）
# LOCAL=~/DevKinsta/public/famurai/wp-content
# REMOTE=famurai@140.83.62.102:/www/famurai_375/public/wp-content
# PORT=61241

# 単一ファイル転送
scp -P 61241 ~/DevKinsta/public/famurai/wp-content/themes/famurai-child/functions.php \
  famurai@140.83.62.102:/www/famurai_375/public/wp-content/themes/famurai-child/

# style.css
scp -P 61241 ~/DevKinsta/public/famurai/wp-content/themes/famurai-child/style.css \
  famurai@140.83.62.102:/www/famurai_375/public/wp-content/themes/famurai-child/

# theme.json
scp -P 61241 ~/DevKinsta/public/famurai/wp-content/themes/famurai-child/theme.json \
  famurai@140.83.62.102:/www/famurai_375/public/wp-content/themes/famurai-child/

# ディレクトリごと転送（例：カスタムプラグイン）
scp -P 61241 -r ~/DevKinsta/public/famurai/wp-content/plugins/famurai-brand-settings \
  famurai@140.83.62.102:/www/famurai_375/public/wp-content/plugins/

# mu-plugins
scp -P 61241 -r ~/DevKinsta/public/famurai/wp-content/mu-plugins/ \
  famurai@140.83.62.102:/www/famurai_375/public/wp-content/mu-plugins/
```

---

## ファイル編集パス

```
~/DevKinsta/public/famurai/wp-content/
├── themes/
│   ├── greenshift/           （親テーマ・直接編集禁止）
│   └── famurai-child/        （カスタマイズはここに）
│       ├── style.css
│       ├── functions.php
│       ├── theme.json
│       ├── templates/
│       └── parts/
├── plugins/
│   └── famurai-*/            （カスタムプラグイン）
└── mu-plugins/               （必須プラグイン）
```

---

## テーマ構成

### 親テーマ: Greenshift

- FSE テーマ
- **直接編集禁止**

### 子テーマ: famurai-child

- `Template: greenshift` で宣言
- 開発中は**Greenshift（親）をアクティブ**のまま使用
  - FSE テンプレートが greenshift スラッグに紐付いているため

---

## プラグイン構成（確定）

### デモ用（13本）

| # | プラグイン | 用途 |
|---|---------|------|
| 1 | WooCommerce | EC基盤 |
| 2 | Rank Math SEO | SEO・リダイレクト・スキーマ |
| 3 | Fluent Forms | 軽量フォーム（ブロック対応） |
| 4 | WP Multibyte Patch | 日本語必須（文字化け防止） |
| 5 | Loco Translate | 未翻訳部分の日本語調整 |
| 6 | Download Monitor | ファイルDL管理・追跡 |
| 7 | BetterDocs | ナレッジベース・FAQ |
| 8 | Real Custom Post Order | ドラッグ&ドロップ並び替え |
| 9 | Advanced Custom Fields | カスタムフィールド |
| 10 | Extra Custom Product Tabs for WooCommerce | 商品タブ追加 |
| 11 | Smart Slider 3 | Hero スライダー |
| 12 | FiboSearch | Ajax商品検索 |
| 13 | Variation Swatches for WooCommerce | バリエーション表示 |

### 本番追加（+1本）

| # | プラグイン | 用途 |
|---|---------|------|
| 14 | Fluent SMTP | メール送信（完全無料） |

---

## ホスティング（本番）

**Kinsta**
- DevKinsta → 「同期」→「Staging にプッシュ」で反映
- 東京・大阪リージョン確定

---

## 次のステップ

タスク一覧・進捗は tasks.md で管理しています。
パス: ~/Documents/Obsidian Vault/projects/famurai-demo/tasks.md
