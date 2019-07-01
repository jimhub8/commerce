<template>
<div>
<Best></Best>
<Featured></Featured>
<NewProduct></NewProduct>    
</div>
</template>
 
<script>
import NewProduct from './type/New'
import Featured from "./type/Featured";
import Best from "./type/Best";
export default {
    components: {
        NewProduct, Best, Featured
    }
}
</script>

<style scoped>

</style>
