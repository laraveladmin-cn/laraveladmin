<?php
$str = <<<'str'
{
    "accepted": ":attribute을(를) 동의해야 합니다.",
    "active_url": ":attribute은(는) 유효한 URL이 아닙니다.",
    "after": ":attribute은(는) :date 이후 날짜여야 합니다.",
    "after_or_equal": ":attribute은(는) :date 이후 날짜이거나 같은 날짜여야 합니다.",
    "alpha": ":attribute은(는) 문자만 포함할 수 있습니다.",
    "alpha_dash": ":attribute은(는) 문자, 숫자, 대쉬(-), 밑줄(_)만 포함할 수 있습니다.",
    "alpha_num": ":attribute은(는) 문자와 숫자만 포함할 수 있습니다.",
    "array": ":attribute은(는) 배열이어야 합니다.",
    "before": ":attribute은(는) :date 이전 날짜여야 합니다.",
    "before_or_equal": ":attribute은(는) :date 이전 날짜이거나 같은 날짜여야 합니다.",
    "between": {
        "numeric": ":attribute의 값은 :min에서 :max 사이여야 합니다.",
        "file": ":attribute의 용량은 :min에서 :max 킬로바이트 사이여야 합니다.",
        "string": ":attribute의 길이는 :min에서 :max 문자 사이여야 합니다.",
        "array": ":attribute의 항목 수는 :min에서 :max 개의 항목이 있어야 합니다."
    },
    "boolean": ":attribute은(는) true 또는 false 이어야 합니다.",
    "confirmed": ":attribute 확인 항목이 일치하지 않습니다.",
    "date": ":attribute은(는) 유효한 날짜가 아닙니다.",
    "date_equals": ":attribute은(는) :date과(와) 같은날짜여야합니다.",
    "date_format": ":attribute이(가) :format 형식과 일치하지 않습니다.",
    "different": ":attribute와(과) :other은(는) 서로 달라야 합니다.",
    "digits": ":attribute은(는) :digits 자리 숫자여야 합니다.",
    "digits_between": ":attribute)은(는) :min에서 :max 자리 사이여야 합니다.",
    "dimensions": ":attribute은(는) 올바르지 않는 이미지 크기입니다.",
    "distinct": ":attribute 필드에 중복된 값이 있습니다.",
    "email": ":attribute은(는) 유효한 이메일 주소여야 합니다.",
    "ends_with": ":attribute은(는) 다음 중 하나로 끝나야 합니다: :values.",
    "exists": "선택된 :attribute은(는) 올바르지 않습니다.",
    "file": ":attribute은(는) 파일이어야 합니다.",
    "filled": ":attribute 필드는 값이 있어야 합니다.",
    "gt": {
        "numeric": ":attribute의 값은 :value보다 커야 합니다.",
        "file": ":attribute의 용량은 :value킬로바이트보다 커야 합니다.",
        "string": ":attribute의 길이는 :value보다 길어야 합니다.",
        "array": ":attribute의 항목 수는 :value개 보다 많아야 합니다."
    },
    "gte": {
        "numeric": ":attribute의 값은 :value보다 같거나 커야 합니다.",
        "file": ":attribute의 용량은 :value킬로바이트보다 같거나 커야 합니다.",
        "string": ":attribute의 길이는 :value보다 같거나 길어야 합니다.",
        "array": ":attribute의 항목 수는 :value개 보다 같거나 많아야 합니다."
    },
    "image": ":attribute은(는) 이미지여야 합니다.",
    "in": "선택된 :attribute은(는) 올바르지 않습니다.",
    "in_array": ":attribute 필드는 :other에 존재하지 않습니다.",
    "integer": ":attribute은(는) 정수여야 합니다.",
    "ip": ":attribute은(는) 유효한 IP 주소여야 합니다.",
    "ipv4": ":attribute은(는) 유효한 IPv4 주소여야 합니다.",
    "ipv6": ":attribute은(는) 유효한 IPv6 주소여야 합니다.",
    "json": ":attribute은(는) JSON 문자열이어야 합니다.",
    "lt": {
        "numeric": ":attribute의 값은 :value보다 작아야 합니다.",
        "file": ":attribute의 용량은 :value킬로바이트보다 작아야 합니다.",
        "string": ":attribute의 길이는 :value보다 짧아야 합니다.",
        "array": ":attribute의 항목 수는 :value개 보다 작아야 합니다."
    },
    "lte": {
        "numeric": ":attribute의 값은 :value보다 같거나 작아야 합니다.",
        "file": ":attribute의 용량은 :value킬로바이트보다 같거나 작아야 합니다.",
        "string": ":attribute의 길이는 :value보다 같거나 짧아야 합니다.",
        "array": ":attribute의 항목 수는 :value개 보다 같거나 작아야 합니다."
    },
    "max": {
        "numeric": ":attribute은(는) :max보다 클 수 없습니다.",
        "file": ":attribute은(는) :max킬로바이트보다 클 수 없습니다.",
        "string": ":attribute은(는) :max자보다 클 수 없습니다.",
        "array": ":attribute은(는) :max개보다 많을 수 없습니다."
    },
    "mimes": ":attribute은(는) 다음의 파일 형식이어야 합니다: :values.",
    "mimetypes": ":attribute은(는) 다음의 파일 형식이어야 합니다: :values.",
    "min": {
        "numeric": ":attribute은(는) 최소한 :min이어야 합니다.",
        "file": ":attribute은(는) 최소한 :min킬로바이트이어야 합니다.",
        "string": ":attribute은(는) 최소한 :min자이어야 합니다.",
        "array": ":attribute은(는) 최소한 :min개의 항목이 있어야 합니다."
    },
    "not_in": "선택된 :attribute이(가) 올바르지 않습니다.",
    "not_regex": ":attribute의 형식이 올바르지 않습니다.",
    "numeric": ":attribute은(는) 숫자여야 합니다.",
    "password": "비밀번호가 잘못되었습니다.",
    "present": ":attribute 필드가 있어야 합니다.",
    "regex": ":attribute 형식이 올바르지 않습니다.",
    "required": ":attribute 필드는 필수입니다.",
    "required_if": ":other이(가) :value 일 때 :attribute 필드는 필수입니다.",
    "required_unless": ":other이(가) :values에 없다면 :attribute 필드는 필수입니다.",
    "required_with": ":values이(가) 있는 경우 :attribute 필드는 필수입니다.",
    "required_with_all": ":values이(가) 모두 있는 경우 :attribute 필드는 필수입니다.",
    "required_without": ":values이(가) 없는 경우 :attribute 필드는 필수입니다.",
    "required_without_all": ":values이(가) 모두 없는 경우 :attribute 필드는 필수입니다.",
    "same": ":attribute와(과) :other은(는) 일치해야 합니다.",
    "size": {
        "numeric": ":attribute은(는) :size (이)여야 합니다.",
        "file": ":attribute은(는) :size킬로바이트여야 합니다.",
        "string": ":attribute은(는) :size자여야 합니다.",
        "array": ":attribute은(는) :size개의 항목을 포함해야 합니다."
    },
    "starts_with": ":attribute은(는) :values 중 하나로 시작해야 합니다.",
    "string": ":attribute은(는) 문자열이어야 합니다.",
    "timezone": ":attribute은(는) 올바른 시간대 이어야 합니다.",
    "unique": ":attribute은(는) 이미 사용 중입니다.",
    "uploaded": ":attribute을(를) 업로드하지 못했습니다.",
    "url": ":attribute 형식은 올바르지 않습니다.",
    "uuid": ":attribute은(는) 유효한UUID여야합니다.",
    "custom": {
        "attribute-name": {
            "rule-name": "custom-message"
        }
    },
    "attributes": {
        "name": "명칭.",
        "username": "사용자 이름",
        "email": "메 일주 소",
        "first_name": "이름.",
        "last_name": "성.",
        "password": "비밀 번호",
        "password_confirmation": "비밀번호 확인",
        "city": "도시.",
        "country": "나라.",
        "address": "주소.",
        "phone": "전화기",
        "mobile": "핸드폰",
        "age": "나이.",
        "sex": "성별.",
        "gender": "성별.",
        "day": "하늘.",
        "month": "달.",
        "year": "나이.",
        "hour": "시.",
        "minute": "분.",
        "second": "초.",
        "title": "표제.",
        "content": "내용.",
        "description": "묘사 하 다.",
        "excerpt": "요약 하 다.",
        "date": "날짜.",
        "time": "시간.",
        "available": "사용 가능 하 다",
        "size": "크기.",
        "mobile_phone": "핸드폰 번호",
        "old_password": "오래된 비밀번호",
        "file": "문건.",
        "order": "정렬 하 다.",
        "where": "필터 조건"
    },
    "ckeck_password": ":attribute 가 정확 하지 않 습 니 다.",
    "mobile_phone": ":attribute 가 정확 하지 않 습 니 다.",
    "array_keys_in_array": "선 택 된 속성:attribute 불법.",
    "array_in_array": "선 택 된 속성:attribute 불법.",
    "sting_or_array": "선 택 된 속성:attribute 불법.",
    "url_path": ":attribute 형식 이 잘못 되 었 습 니 다."
}
str;
return json_decode($str,true);
