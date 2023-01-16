<div class="sideProdCat">
    @foreach($shop->GetCategoryMap() as $catName=>$cat)

        <a href="#ykm_{{md5($catName)}}">
            {{$catName}} <span class="badge badge-dark float-end">{{$cat['count']}}</span>
        </a>

    @endforeach

</div>
