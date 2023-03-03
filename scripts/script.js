const commentHandle = document.querySelectorAll('.main__content-comment-text')
const commentForms = document.querySelectorAll('.main__content-comment-form')
const commentBtn = document.querySelectorAll('.main__content-comment-btn')


const textareaCleaner = ( node ) => node.value = ''

const addOrFormSwitch = ( event ) => {
    let node = event.target

    if (node.id === 'paragraph_tag') {
        node.classList.toggle('hidden')
        node.parentNode.querySelector('form').classList.toggle('hidden')
        return 
    } else if (node.id === 'button_tag'){
        node.parentNode.classList.toggle('hidden')
        node.parentNode.parentNode.querySelector('p').classList.toggle('hidden')
        return
    }

    node.parentNode.querySelector('form').classList.toggle('hidden')
    node.classList.toggle('hidden')
}
const formSerialize = ( event ) => {
    const column_to_comment = event.target.id
    const company_title = event.target.parentNode.id

    const { elements } = event.target
    const formData = Array.from(elements)
        .filter((item) => !!item.value)
           .map((element) => {
            const { name, value } = element
            
            return { name, value }
        
    })

    const formValue = formData[0].value

    const data = { company_title, column_to_comment, formValue }

    return data
}

const insertResponse = ( res, column ) => {
    
    const comment = document.createElement('p')
    
    comment.className = 'main__content-item-comment';
    comment.id = 'comment_' + column
    comment.innerHTML = `${res}`
    if (column === 'company') {
        const before_comments = document
            .querySelector('#wrapper_' + column)

        before_comments.insertAdjacentHTML('afterbegin', comment.outerHTML)
        
    } else {
        const before_comments = document
            .querySelector('#wrapper_' + column)
            .querySelector('#before_comments')
        
        before_comments.insertAdjacentHTML('afterend', comment.outerHTML)  
    }
    
}

const formHandle = ( event ) => {
    event.preventDefault()

    const column_to_comment = event.target.id
    const textarea = event.target
        .querySelector('textarea')


    $.ajax({
        type: "post",
        url: "comment.php",
        data: formSerialize(event),
        success: ( response ) => {
            console.log(response);
            textareaCleaner(textarea)
            insertResponse(response, column_to_comment)

        }
    })

}


commentHandle.forEach(handle => handle.addEventListener('click', addOrFormSwitch))
commentBtn.forEach(btn => btn.addEventListener('click', addOrFormSwitch))

commentForms.forEach(form => form.addEventListener('submit', formHandle))

