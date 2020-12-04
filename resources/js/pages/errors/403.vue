<template>
    <div class="error_404 error-page">
        <h2 class="headline text-yellow"> 403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 该页面你无权访问！</h3>
            <p>
                该页面你无权访问,请联系相关人员！你可以点击<a>首页</a>返回
            </p>
            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="搜索">
                    <div class="input-group-btn">
                        <button type="button" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
    };
</script>
