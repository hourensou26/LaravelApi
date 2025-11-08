---
created: 2025年09月23日(火)
topic: 要件定義書
tags: [2025-09-23,要件定義書]
---
---

本文中のタグ↓
#Laravel #React 

## 目的

本ドキュメントはシステム開発に関する要件定義書になります。

## 概要

### システム方式・構成

システム構成は次の通りです。

- Users──< Tasks >──Projects
- Tasks──< TaskAssignments >──Users
- Tasks──< ScheduleEntries >──Calendars
- AuditLogs──(関連:全テーブルに対する操作記録)

### 用語定義

- Users: ユーザー情報を管理
- Projects: プロジェクト情報を管理
- Tasks: タスク情報を管理
- Calendars: カレンダー情報を管理
- TaskAssignments: タスクと担当ユーザーの対応関係
- ScheduleEntries: スケジュール枠の管理
- AuditLogs: 操作履歴の管理

### 構築後のフロー

システム構築後、フローは次のようになります。

1. [ログイン]
2. [タスク一覧]
3. [タスク編集]
4. [日次スケジュール]

## 機能要件

### 画面

- ログイン画面
- タスク一覧画面
- タスク編集画面
- 日次スケジュール画面

### 情報・データ

本システムでは以下のデータが作成されます。

- **Users**
  - UserID (INT, PK): ユーザーID
  - UserName (VARCHAR(100)): ユーザー名
- **Projects**
  - ProjectID (INT, PK): プロジェクトID
  - ProjectName (VARCHAR(100)): プロジェクト名
- **Calendars**
  - CalendarID (INT, PK): カレンダーID
- **Tasks**
  - TaskID (INT, PK): タスクID
  - Title (VARCHAR(200)): タスク名
- **TaskAssignments**
  - TaskID (INT, PK, FK→Tasks): タスクID
  - UserID (INT, PK, FK→Users): 担当ユーザーID
- **ScheduleEntries**
  - EntryID (INT, PK): スケジュール枠ID
- **AuditLogs**
  - 各テーブルの操作履歴を記録

### 外部インタフェース

- （未定義）

### データフロー

本システムのデータ処理は次のようになります。

1. ユーザーがログイン
2. タスク一覧を取得し表示
3. タスク編集・更新処理
4. スケジュール枠とカレンダーを関連付け
5. 操作内容をAuditLogsに記録

## 非機能要件

- パフォーマンス要件（未定義）
- セキュリティ要件（未定義）
- 運用・保守要件（未定義）

---
## リンクなど
- []()
