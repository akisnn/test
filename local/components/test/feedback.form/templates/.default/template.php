<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<section id="feedback_form">
    <h1>Форма обратной связи</h1>
    <form method="post" id="fos" name="fos">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="nickname"><br><br>
        <label for="pros">Плюсы:</label><br>
        <textarea id="pros" name="pros" rows="4"></textarea><br><br>
        <label for="cons">Минусы:</label><br>
        <textarea id="cons" name="cons" rows="4"></textarea><br><br>
        <label for="review">Отзыв:</label><br>
        <textarea id="review" name="review" rows="6"></textarea><br><br>
        <input id="SEND" type="button" value="Отправить">
    </form>
</section>
<section id="feedback_form_results">
    <h1>Опубликованные отзывы</h1>
    <?php foreach($arResult['REVIEWS'] as $REVIEW){?>
    <div class="review">
        <div class="review_name">Имя: <?php echo $REVIEW['NICKNAME_VALUE'];?></div>
        <div class="review_pros">Плюсы: <?php echo $REVIEW['PROS_VALUE'];?></div>
        <div class="review_cons">Минусы: <?php echo $REVIEW['CONS_VALUE'];?></div>
        <div class="review_review">Отзыв: <?php echo $REVIEW['REVIEW_VALUE'];?></div>
    </div><br>
    <?php }?>
</section>
