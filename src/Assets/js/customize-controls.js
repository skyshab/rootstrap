/**
 * Scripts for working with customizer control actions
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
 * Main Rootstrap Class
 */
class Rootstrap {

    constructor() {
        // define api attribute
        this.api = wp.customize;

        // if wp.customize is not defined, return
        if( ! this.api ) return false;

        // define registered devices
        this.devices = rootstrapData.devices;

        // do our thang
        this.init();
    }


    /*
     * Let's get to it
     */    
    init() {
        // initialize tab functionality
        this.initializeNavLink();

        // setup device data
        this.setDeviceData();        
    }

    
    /*
     * Get list of device names
     */
    getDeviceList() {
        return Object.keys( this.devices );
    }


    /*
     * Get a device id from a specified width
     */
    getDevice( width ) {

        var device = false;

        for (const [name, data] of Object.entries( this.devices ) ) {

            if( !name || !data ) continue;
            var min = ( parseInt( data.min, 10 ) ) ? parseInt( data.min, 10 ): 0;
            var max = ( parseInt( data.max, 10 ) ) ? parseInt( data.max, 10 ): 9999;
 
            if( width >= min && width <= max )
                device = name;
                return false;            
        }

        return device;
    }


    /*
     * Get the device id that matches the current preview screen width
     */
    getCurrentDevice() {
        return getDevice( this.getPreviewWidth() );
    }


    /*
     * Get the current preview screen width
     */
    getPreviewWidth() {
        var iframe = document.querySelector("#customize-preview iframe");
        var iframeDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
        return iframeDoc.body.offsetWidth()
    }


    /*
     * When opening a section, open the associated device in preview.This requires 
     * the section "type" to be set to a specific value, which is then used to determine 
     * the device by its class name. This is sloppy. We need to figure out how to add 
     * a data value on sections of any type. 
     */
    setDeviceData() {

        const api = this.api;

        document.querySelectorAll('.accordion-section-title').forEach( ( title ) => {
            title.addEventListener("click", (e) => { 
                var classNames = e.target.parentElement.classList;
                for ( let className of classNames ) {
                    if( className.indexOf('rootstrap-device--') !== -1 )
                        api.previewedDevice.set( className.replace('control-section-rootstrap-device--', '') );                    
                        return false;                                   
                }  
            });
        });      
    }


    /*
     * Add click handler to rootstrap tabs controls in the customizer
     */
    initializeNavLink() {

        const api = this.api;

        document.querySelectorAll('.rootstrap-nav-link').forEach( function( elem ) {
            
            var section = elem.dataset.section;
            var device = elem.dataset.device;

            elem.addEventListener("click", (e) => { 
                if( api.section( section ) )
                    api.section( section ).activate();
                    api.section( section ).focus();
    
                    if( device )                  
                        api.previewedDevice.set( device );
                    else
                        var type = api.section( section ).params.type;
                        if( type && type.indexOf('rootstrap-device--') !== -1 )
                            api.previewedDevice.set( type.replace('rootstrap-device--', '') );                            
            });
        });
    }
}

 
/*
 * Create our Rootstrap Instance on document ready
 */
document.addEventListener( "DOMContentLoaded", function() {
    const rootstrap = new Rootstrap();
});
