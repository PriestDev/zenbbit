(function() {
    on('click', '#dowmload-pack', function() {
        if (this.checked) {
            select('#downloadLogo').classList.remove('disabled')
        } else {
            select('#downloadLogo').classList.add('disabled') 
        }
    });
    on('click', '#downloadLogo', function() {
        if (!select('#dowmload-pack').checked) { return }
        window.open('https://www.figma.com/file/NzGySSmxkCddJpqZ6jEjeP/media-kit?type=design&node-id=25-1911&mode=design&t=RoXsqce9MkFZv5EO-0');
        // const url = '/pub/SafePalLogoFiles.zip'
        // const link = document.createElement('a') // 创建a标签
        // link.href = url // a标签添加属性
        // link.style.display = 'none'
        // document.body.appendChild(link)
        // link.click() // 执行下载
        // URL.revokeObjectURL(link.href) // 释放url
        // document.body.removeChild(link) // 释放标签
    })

})()