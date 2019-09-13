<template>
    <md-field>
      <label>{{ lb }}</label>
      <md-textarea></md-textarea>
    </md-field>
</template>
<script>
export default {
    name: 'textarea',
    props: {
        lb: String,
    }
}
</script>