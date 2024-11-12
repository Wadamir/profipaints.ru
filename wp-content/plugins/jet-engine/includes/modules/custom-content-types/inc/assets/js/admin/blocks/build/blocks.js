(()=>{"use strict";const e=window.React,{TextareaControl:t,SelectControl:n,PanelBody:i,Button:s}=wp.components,a=class extends wp.element.Component{constructor(e){super(e),this.handleChange=this.handleChange.bind(this),this.queryDialog=null}componentDidMount(){this.queryDialog=new JetQueryDialog({listing:this.props.attributes.lisitng_id,fetchPath:window.JetEngineCCTBlocksData.fetchPath,value:this.props.attributes.jet_cct_query,onSend:(e,t)=>{this.handleChange("jet_cct_query",e)}})}componentWillUnmount(){this.queryDialog.remove()}handleChange(e,t){var n=JSON.parse(JSON.stringify(this.props.attributes));n[e]=t,this.props.onChange(n)}render(){return(0,e.createElement)(i,{title:"Content Types Query",initialOpen:!1},(0,e.createElement)(t,{label:"Query String",help:"Use the button below to generate query string",value:this.props.attributes.jet_cct_query,onChange:e=>{this.handleChange("jet_cct_query",e)}}),(0,e.createElement)(s,{label:"Generate Query",isSecondary:!0,isSmall:!0,onClick:()=>{var e=this.props.attributes.jet_cct_query||"{}";this.queryDialog.setOptions({listing:this.props.attributes.lisitng_id}),this.queryDialog.setValue(JSON.parse(e)),this.queryDialog.create()}},"Generate Query"),window.JetEngineCCTBlocksData.stores&&window.JetEngineCCTBlocksData.stores.length&&(0,e.createElement)("div",{style:{paddingTop:"20px"}},(0,e.createElement)(n,{label:"Get items from store",value:this.props.attributes.jet_cct_from_store,options:window.JetEngineCCTBlocksData.stores,onChange:e=>{this.handleChange("jet_cct_from_store",e)}})))}};window.JetEngineListingData.customPanles.listingGrid||(window.JetEngineListingData.customPanles.listingGrid=[]),window.JetEngineListingData.customPanles.listingGrid.push(a)})();
//# sourceMappingURL=blocks.js.map