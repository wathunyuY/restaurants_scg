export const state = () => ({
    lists: [],
    keyword: 'Bang sue',
    next: null,
    previous: null,
    typeCard: true,
    loading: false
})

export const mutations = {
    setLists(state, lists) {
        state.lists = lists
    },
    insertLists(state, lists) {
        state.lists = state.lists.concat(lists)
    },
    setNext(state, next) {
        state.next = next
    },
    setKeyword(state, keyword) {
        state.keyword = keyword
    },
    setTypeCard(state) {
        state.typeCard = !state.typeCard
    },
    setLoading(state, val) {
        state.loading = val;
    },
    setPrevious(state, val) {
        state.previous = val
    }
}

export const actions = {
    /**
     * Get restaurants by key word
     * @param {String} keyword Text of some detail of restaurant -- exmple : Bang sue
     */
    async getRestaurants({ dispatch, commit }, keyword) {
        commit('setLoading', true); //Show loading overlay in form search
        commit('setKeyword', keyword);
        this.$axios.get(`api/find?keyword=${keyword}`).then(res => {
                if (res.status === 200) {
                    commit('setLists', res.data.results) // Set restaurants 
                    commit('setNext', res.data.next) // Set nex page token
                }
            })
            .catch(err => dispatch('buildError', err.response.data)) //Alert when error
            .then(() => commit('setLoading', false)) //Close loading overlay in form search
    },
    /**
     * Get next list of restaurants by next page token
     */
    async getRestaurantsNextpage({ dispatch, commit, state }) {
        if (state.previous && state.next == state.previous) return; //Check duplicate token
        let prev = state.previous; // Old prev previous for reset
        commit('setPrevious', state.next) // Set previous page token
        this.$axios.get(`api/find?next=${state.next}`).then(res => {
            if (res.status === 200) {
                commit('insertLists', res.data.results) // Append restaurants
                commit('setNext', res.data.next) // Set next page token
            }
        }).catch(err => {
            commit('setPrevious', prev) // Reset previous value
            dispatch('buildError', err.response.data)
        })

    },
    /**
     * Build and alert error
     * @param {String} text error text 
     */
    buildError({ commit }, text) {
        $nuxt.$bvToast.toast(`${text}`, {
            title: `Somthing was wrong`,
            autoHideDelay: 5000,
            appendToast: true,
            toaster: 'b-toaster-bottom-right'
        })
    }
}
export const getters = {
    getTransformRestaurants: state => {
        return state.lists
            .map((m, i) => ({
                place_id: m.place_id,
                photos: m.photos,
                formatted_address: m.formatted_address.length >= 15 ? m.formatted_address.slice(0, 14) + "..." : m.formatted_address,
                address: m.formatted_address,
                name: m.name,
                rating: m.rating
            }))
    },
    getCountOfRestaurant: state => {
        return state.lists.length;
    }
}