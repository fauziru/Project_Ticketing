<template>
    <md-field>
      <label>{{ lb }}</label>
      <md-button></md-button>
    </md-field>
</template>
<script>
export default {
    name: 'button',
    props: {
        lb: String,
    }
}
</script>