'use strict';

window.addEventListener('DOMContentLoaded',() => {
    setTimeout(() => {
        $('.alert-success, .alert-danger').fadeOut(5000);
    },2000);

    // const successMessage = () => {
    //     $('.alert-success').fadeIn();
        
    //     setTimeout(() => {
    //         $('.alert-success').fadeOut(5000);
    //     },2000);
    // }

    // export function successMessage() {
    //     $('.alert-success').fadeIn();
        
    //     setTimeout(() => {
    //         $('.alert-success').fadeOut(5000);
    //     },2000);
    // }

    const dangerMessage = () => {
        $('.alert-danger').fadeIn();
        
        setTimeout(() => {
            $('.alert-danger').fadeOut(5000);
        },2000);
    }
});

export const successMessage = () => {
    $('.alert-success').fadeIn();
    
    setTimeout(() => {
        $('.alert-success').fadeOut(5000);
    },2000);
}