<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "編譯生成前端入口檔案“index.html”",
    "Execute all migration files": "執行所有遷移檔案",
    "Is the \":file\" file already overwritten?": "檔案“：file”已存在是否覆蓋？[y|N]",
    "The \":file\" file already exists": "檔案“：file”已存在",
    "File \":file\" created successfully": "檔案“：file”創建成功",
    "Failed to create file \":file\"": "檔案“：file”創建失敗",
    "Generate all resources": "生成所有資源",
    "Custom template controller generation": "自定義範本控制器生成",
    "Created At": "創建時間",
    "Updated At": "修改時間",
    "Deleted At": "删除時間",
    "Custom template model generation": "自定義範本模型生成",
    "Custom template data fill file generation": "自定義範本數據填充檔案生成",
    "Custom template front-end view generation": "自定義範本前端視圖生成",
    "The application language is not set to English to execute": "應用的語言不是設定為英語時才可執行",
    "From \":old\" to \":new\"": "從“：old”至“：new”",
    "Failed to translate \":old\"": "翻譯“：old”失敗",
    "Failed to translate \":old\" into \":lang\"": "翻譯“：old”成“：lang”失敗",
    "This command can only be executed in the development environment": "只能在開發環境才可執行該命令",
    "Automatic scan to generate Api document data": "自動掃描生成Api檔案數據",
    "Initializing the creation of a soft connection": "初始化創建軟連接",
    "The \":link\" link has been connected to \":target\"": "軟連接“：link”已經連接到“：target”",
    "The links have been created": "連結已經全部創建",
    "Generate software code text for software copyright application": "生成申請軟件著作權的軟件程式碼文字",
    "To enable support for relative links, please install the symfony/filesystem package": "要啟用相對連結的支持，請安裝symfony/filesystem包",
    "Failed to delete file \":file\"": "刪除檔”：file”失敗"
}
str;
return json_decode($str,true);