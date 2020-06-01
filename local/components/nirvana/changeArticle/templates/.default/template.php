<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<changearticle></changearticle>
<script>
    Vue.component('changearticle', {
        data: function () {
            return {
                item: <?=json_encode($arResult['item'])?>,
                sections: <?=json_encode($arResult['sections'])?>,
                //text: <?//=json_encode($arResult['text'])?>//,
            }
        },
        template: `<div class="article">
<h1 class="h1_manag">Добавить статью</h1>
    <form class="addform" ENCTYPE="multipart/form-data">
        <div class="massege"></div>

        <div class="form-group">

            <label for="title-element">Title (заголовок который в коде)</label>
            <input id="title-element" v-model="item.name" type="text" class="form-control"
                   placeholder="Title (заголовок который в коде)">
        </div>

        <div class="form-group">
            <label for="name-element">Название статьи - в списке ( ссылка тоже создается )</label>
            <input id="name-element" v-model="item.name" type="text" class="form-control" placeholder="Название статьи">
        </div>

        <div class="form-group">
            <label for="description-element">Анонс статьи и Description</label>
            <textarea v-model="item.preview_text" id="description-element" class="form-control" rows="5"
                      placeholder="Анонс статьи"></textarea>
            <p class="counter">Количество символов <span class="col_simvol">0</span></p>
        </div>

            <div class="form-group">
                <label for="razdel-element">Разделы</label>
                <select v-model="item.section" class="form-control">
                        <option v-for="section in sections" :value="section.id">{{section.name}}</option>
                </select>
            </div>
        <div class="form-group">
            <label for="photo-element">Фото статьи</label>
               <img v-if="item.detail_picture" :src="item.detail_picture">
            <input type="file" name="photo" class="form-control" id="photo-element">
        </div>

        <div class="form-group">
            <label for="h1-element">h1 - видимый заголовок</label>
            <input id="h1-element" v-model="item.name" type="text" class="form-control" placeholder="h1">
        </div>

        <div class="form-group">
            <label for="text-element">Текст статьи</label>
           <textarea v-model="item.detail_text"></textarea>
        </div>

        <div class="form-group">
            <label for="tags-element">Теги через запятую</label>
            <input id="tags-element" v-model="item.tags" type="text" class="form-control">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Добавить">
        </div>

    </form>
</div>`,
        methods:{
            sendInfo: function (evt,formId,formRes) {
        evt.preventDefault();
        let formData = new FormData(formId);
        formData.append('form',formRes);
        axios.post("<?=$this->__component->__path?>/changeInfo.php", formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then((response) => {
                console.log('done',response.data)
            })
            .catch((error) => {
                console.log(error);
            });
    }
        }
    })
</script>
