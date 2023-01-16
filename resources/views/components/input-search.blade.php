<style>
    .inputSearchGlobal > * {
        border-radius: 16px;
        border: 2px solid #000;
        height: 47px !important;
    }

    .inputSearchGlobal > span {
        padding: 0px 10px;
        border-right: none;
    }

    .inputSearchGlobal > input {
        background: transparent !important;
        border-left: none;
        border-right: none;
        padding: 1px;
        padding-left: 5px;
    }

    .inputSearchGlobal > .btn {
        background: #000;
        border-left: none;
    }

    .inputSearchGlobal > input:focus {
        outline: none !important;

    }

    .inputSearchGlobal {
        xborder: 2px solid #000;
    }
</style>


<div class="input-group  inp_{{$ind}}   inputSearchGlobal" style="
  @error($ind) border-color:#ff2f00; @enderror
">
    <span class="input-group-text" id="addon-wrapping">
        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M15.5 14H14.71L14.43 13.73C15.41 12.59 16 11.11 16 9.5C16 5.91 13.09 3 9.5 3C5.91 3 3 5.91 3 9.5C3 13.09 5.91 16 9.5 16C11.11 16 12.59 15.41 13.73 14.43L14 14.71V15.5L19 20.49L20.49 19L15.5 14ZM9.5 14C7.01 14 5 11.99 5 9.5C5 7.01 7.01 5 9.5 5C11.99 5 14 7.01 14 9.5C14 11.99 11.99 14 9.5 14Z"
      fill="#020202"/>
</svg>


    </span>
    <input type="text"
           name="{{$ind}}"
           value="{{ old($ind)??"" }}"
           class="form-control" placeholder="{{$placeholder??"Поиск по продуктам"}}" aria-describedby="button-addon2">
    <button class="btn btn-primary" type="button" id="button-addon2">Найти</button>
</div>

