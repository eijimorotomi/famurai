# Famurai デモサイト — Claude Code コンテキスト

## セッション開始手順

> このファイルを読んだら、次に以下のファイルを読んでタスクを確認してください。
> パス: ~/Documents/Obsidian Vault/projects/famurai-demo/tasks.md
>
> - 「作業中」のタスクがあればそこから着手する
> - 「グローバル設定（初回のみ）」が未完了であれば最優先で実行する
> - タスク完了時は tasks.md のチェックボックスを更新する

---

## プロジェクト概要

- **サイト名**: Famurai（ファムライ）— 架空の音楽機材・オーディオ輸入代理店
- **目的**: クライアント（完実電気・銀座十字屋）向け提案用デモサイト
- **サイトURL**: http://localhost:8080
- **管理画面**: http://localhost:8080/wp-admin（admin / admin1234）
- **phpMyAdmin**: http://localhost:8081

---

## 開発環境

### 構成

| サービス | コンテナ名 | イメージ |
|---------|----------|--------|
| WordPress（Apache） | famurai_wp | wordpress:php8.2-apache |
| データベース（MySQL） | famurai_db | mysql:8.0 |
| WP-CLI | famurai_wpcli | wordpress:cli-php8.2 |
| phpMyAdmin | famurai_phpmyadmin | phpmyadmin:latest |

### 起動・停止

```bash
# 起動（-d: バックグラウンド実行）
docker-compose up -d

# 停止
docker-compose down

# ログ確認
docker-compose logs -f wp
```

### WP-CLI の使い方

```bash
# 書式: docker-compose run --rm --entrypoint=wp wpcli <コマンド>
docker-compose run --rm --entrypoint=wp wpcli plugin list
docker-compose run --rm --entrypoint=wp wpcli cache flush
docker-compose run --rm --entrypoint=wp wpcli theme list
```

---

## テーマ構成

### 親テーマ: Twenty Twenty-Five（TT5）

- WordPress公式 FSEテーマ
- **直接編集禁止**（テーマ更新で上書きされる）

### 子テーマ: famurai-child ← すべてのカスタマイズはここに

```
wordpress/wp-content/themes/famurai-child/
├── style.css      （テーマ宣言: Template: twentytwentyfive）
├── functions.php  （親スタイル読み込み）
├── theme.json     （Famurai デザイントークン）
├── templates/     （FSE ページテンプレート）
└── parts/         （再利用パーツ）
```

#### Git 管理対象

```
wordpress/wp-content/themes/famurai-child/  ← ここだけ管理
wordpress/wp-content/plugins/famurai-*/     ← カスタムプラグイン
```

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

**Kinsta**（現在利用中）
- 東京・大阪リージョン確定
- WooCommerceキャッシュバイパス自動設定
- Cloudflare Enterprise WAF・CDN内蔵
- 自動バックアップ14日分内蔵

---

## よく使うコマンド

```bash
# キャッシュクリア
docker-compose run --rm --entrypoint=wp wpcli cache flush

# テーマ確認
docker-compose run --rm --entrypoint=wp wpcli theme list --status=active

# プラグイン確認
docker-compose run --rm --entrypoint=wp wpcli plugin list --status=active

# パーマリンク再生成
docker-compose run --rm --entrypoint=wp wpcli rewrite flush

# WordPress コンテナに入る
docker exec -it famurai_wp bash
```

---

## 次のステップ

タスク一覧・進捗は tasks.md で管理しています。
パス: ~/Documents/Obsidian Vault/projects/famurai-demo/tasks.md
