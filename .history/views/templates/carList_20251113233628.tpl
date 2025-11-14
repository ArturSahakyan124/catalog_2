    {foreach $cars as $car}
    <car-card
        photo="../assets/{$car.photo|escape}"
        name="{$car.name|escape}"
        model="{$car.model|escape}"
        year="{$car.year|escape}"
        id="{$car.id|escape}"
        username="{$car.username|escape}"
        editable="{if $user_id == $car.user_id}true{else}false{/if}">
    </car-card>
    {/foreach}
