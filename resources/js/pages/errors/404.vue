<template>
    <div class="error_404 error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3>
                <i class="fa fa-warning text-yellow"></i>
                {{$tp('Page not found')}}
            </h3>
            <p>
                {{$tp('We could not find the page you were looking for Meanwhile, you may return to')}}
                <a>{{$tp('dashboard')}}</a>
                {{$tp('or try using the search form')}}
            </p>
            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" :placeholder="$t('Search')">
                    <div class="input-group-btn">
                        <button type="button" name="submit" class="btn btn-warning btn-flat">
                            <i class="fa fa-search"></i>
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
        data(){
            return {
                "{lang_path}":'errors'
            }
        }
    };
</script>
