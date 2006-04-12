.global-notice {
	background: #D3D3D3;
    position: fixed;
    top: 20%;
    padding: 15px;
    font-size: 200%;
    line-height: 120%;
    left: 50%;
    border-radius: 7px;
    box-shadow: 1px 1px 100px;
    width: 400px;
    margin-left: -200px;
    overflow-y: auto;
    max-height: 500px;
}
.global-notice-icon {
    vertical-align: middle;
}
.global-notice-caption {
    margin-bottom: 20px;
    border-bottom: 3px solid black;
}
.global-notice-back {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background: white;
}
.global-notice-footer {
    margin-top: 20px;
    border-top: 3px solid black;
    padding-top: 20px;
}
.error .global-notice-caption, .error .global-notice-footer {
	border-color: #BB0000;
}
.info .global-notice-caption, .info .global-notice-footer{
	border-color: #005CB6;
}
.error.global-notice-back {
    background: transparent radial-gradient(ellipse at center center , rgb(187, 0, 0) 0%, rgb(102, 0, 0) 100%) repeat scroll 0% 0%;
}
.info.global-notice-back{
    background: transparent radial-gradient(ellipse at center center , rgb(0, 183, 255) 0%, rgb(3, 43, 215) 100%) repeat scroll 0% 0%;
}
