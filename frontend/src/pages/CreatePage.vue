<script>
export default {
      data:() => ({
        value: ''
      })
    }</script>

<template>
    <div class="container">
        <h1>Create Message</h1>
        <form>
            <div class="center content-inputs">
                <vs-input
                    label-placeholder="Country"
                    v-model="value"/>
                </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
</template>