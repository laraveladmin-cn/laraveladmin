<template>
    <div class="error_500 error-page">
        <h2 class="headline text-red">503</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i>{{$tp('System maintenance')}}</h3>
            <p>
                {{$tp('Please try again later, the system is under maintenance')}}
            </p>
            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" :placeholder="$t('Search')">
                    <div class="input-group-btn">
                        <button type="button" name="submit"  class="btn btn-danger btn-flat">
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
