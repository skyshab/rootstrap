/**
 * Scripts for working with customizer preview actions
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
 * Class for adding styles
 */
class Styles {

    constructor( data ) {
        if ( !data.id || !data.selector ) return false;
        this.screen = data.screen;
        this.id = ( this.screen ) ? `${data.id}--${data.screen}` : data.id;
        this.selector = data.selector;
        this.styles = data.styles;
        this.init();
    }


    init() {
        this.removeStyleblock();
        this.insertStyleblock();
    }


    removeStyleblock() {
        const oldBlock = document.getElementById( this.getHook() );
        if( oldBlock !== null ) oldBlock.remove();             
    }
    

    insertStyleblock() {
        document.head.insertBefore( this.getStyleBlock(), this.getHook() );            
    } 


    openQuery() {

        if( !this.screen ) return '';
        const screens = parent.rootstrapData.screens;
        const screen = screens[this.screen];
        var query = '';

        if( screen.min || screen.max ) {

            query += '@media ';

            if( screen.min )
                query += `(min-width: ${screen.min})`;
                if( screen.max ) 
                    query += ' and ';
            if( screen.max ) 
                query += `(max-width: ${screen.max})`;

            query += '{';
        }
        
        return query;
    }


    getStyles() {

        var styles = this.selector + '{';

        for (const [property, value] of Object.entries(this.styles) ) {
            if( !property || !value ) continue;
            styles += `${property}: ${value};`;
        }

        styles += '}';

        return styles;
    }


    closeQuery() {
        return ( this.screen ) ? '}' : '';
    }


    getStyleBlock() {
        const styleblock = document.createElement("style");
        styleblock.setAttribute("id", this.id);
        styleblock.textContent = this.openQuery() + this.getStyles() + this.closeQuery();
        return styleblock;
    }


    getHook() {
        return document.getElementById( "rootstrap-style-hook--" + this.screen );
    }

}


/*
 * Object for interfacing with rootstrap
 */
const rootstrap = {
    screens : () => {
        return Object.entries( parent.rootstrapData.screens );
    },
    style : (data) => {
        const style = new Styles( data );
    }
};


/*
 * Add style hooks on document ready
 */
document.addEventListener( "DOMContentLoaded", function() {
    for ( let screen of rootstrap.screens() ) {
        var hook = document.createElement("meta");
        var hookID = `rootstrap-style-hook--${screen[0]}`;
        hook.setAttribute("id", hookID);
        hook.setAttribute("name", hookID);
        document.head.appendChild(hook); 
    } 
});
