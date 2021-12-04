<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "컴 파일 생 성 전단 입구 파일 \"index. html\"",
    "Execute all migration files": "모든 이전 파일 실행",
    "Is the \":file\" file already overwritten?": "파일 \": file\" 이 존재 합 니 다. 덮어 쓰 시 겠 습 니까?y | N",
    "The \":file\" file already exists": "파일 \": file\" 이 존재 합 니 다",
    "File \":file\" created successfully": "파일 \": file\" 생 성 성공",
    "Failed to create file \":file\"": "파일 \": file\" 생 성 실패",
    "Generate all resources": "모든 자원 생 성",
    "Custom template controller generation": "사용자 정의 템 플 릿 컨트롤 러 생 성",
    "Created At": "창설 시간",
    "Updated At": "수정 시간",
    "Deleted At": "삭제 시간",
    "Custom template model generation": "사용자 정의 템 플 릿 모델 생 성",
    "Custom template data fill file generation": "사용자 정의 템 플 릿 데이터 충전 파일 생 성",
    "Custom template front-end view generation": "사용자 정의 템 플 릿 전단 보기 생 성",
    "The application language is not set to English to execute": "어 플 리 케 이 션 이 영어 로 설정 되 어 있 을 때 만 가능 한 언어 는 아 닙 니 다.",
    "From \":old\" to \":new\"": "\"old\" 에서 \"new\" 까지",
    "Failed to translate \":old\"": "번역 실패",
    "Failed to translate \":old\" into \":lang\"": "번역 실패",
    "This command can only be executed in the development environment": "개발 환경 에서 만 명령 을 수행 할 수 있 습 니 다.",
    "Automatic scan to generate Api document data": "자동 검색 으로 Api 문서 데이터 생 성",
    "Initializing the creation of a soft connection": "소프트 연결 생성 초기화",
    "The \":link\" link has been connected to \":target\"": "소프트 연결 \":link\" 이 \":target\" 에 연결되었습니다",
    "The links have been created": "링크가 모두 만들어졌습니다.",
    "Generate software code text for software copyright application": "소프트웨어 저작권을 신청하는 소프트웨어 코드 텍스트 생성",
    "To enable support for relative links, please install the symfony/filesystem package": "상대 링크 지원을 사용하려면symfony/file 시스템 패키지를 설치하십시오"
}
str;
return json_decode($str,true);