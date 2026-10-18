<?php
/**
 * Plugin Name: PAH llms.txt Generator
 * Plugin URI:  https://proarticleshub.com/llms-txt-generator/
 * Description: Free llms.txt generator. Adds the [pah_llms_txt_generator] shortcode that builds a correctly formatted llms.txt file in the browser.
 * Version:     1.0.0
 * Author:      Kamran Liaquat Ali
 * Author URI:  https://proarticleshub.com/about-us/
 * License:     MIT
 */

if (!defined('ABSPATH')) {
    exit;
}

add_shortcode('pah_llms_txt_generator', function () {
    return <<<'PAHHTML'
<div id="pah-llmsgen" class="pah-llmsgen">
<style>
.pah-llmsgen{--b:#2563eb;--bd:#dbe3ef;--bg:#f8fafc;--tx:#0f172a;--mu:#64748b;--ok:#15803d;--wa:#b45309;border:1px solid var(--bd);border-radius:14px;padding:20px;background:#fff;color:var(--tx);font-size:16px;margin:0 0 28px}
.pah-llmsgen h2.pah-lg-title{margin:0 0 4px;font-size:24px;border:0;padding:0}
.pah-llmsgen .pah-lg-sub{margin:0 0 16px;color:var(--mu);font-size:15px}
.pah-llmsgen label{display:block;font-size:14px;font-weight:600;margin:12px 0 4px}
.pah-llmsgen .pah-lg-hint{font-size:13px;color:var(--mu);margin:2px 0 6px}
.pah-llmsgen input[type=text],.pah-llmsgen textarea{width:100%;box-sizing:border-box;border:1px solid var(--bd);border-radius:8px;padding:10px;font:inherit;font-size:15px;background:#fff;color:var(--tx)}
.pah-llmsgen textarea{min-height:90px;resize:vertical}
.pah-llmsgen textarea.pah-lg-links{min-height:200px;font-family:ui-monospace,Consolas,monospace;font-size:13px}
.pah-llmsgen .pah-lg-btns{display:flex;flex-wrap:wrap;gap:8px;margin:14px 0}
.pah-llmsgen button{border:1px solid var(--bd);background:var(--bg);color:var(--tx);border-radius:8px;padding:9px 14px;font:inherit;font-size:14px;font-weight:600;cursor:pointer}
.pah-llmsgen button.pah-lg-primary{background:var(--b);border-color:var(--b);color:#fff}
.pah-llmsgen button:hover{filter:brightness(.97)}
.pah-llmsgen .pah-lg-opts{display:flex;flex-wrap:wrap;gap:14px;font-size:14px;margin:10px 0 0}
.pah-llmsgen .pah-lg-opts label{display:inline-flex;align-items:center;gap:6px;font-weight:500;margin:0}
.pah-llmsgen pre{background:#0f172a;color:#e2e8f0;border-radius:10px;padding:14px;overflow:auto;max-height:420px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;margin:8px 0}
.pah-llmsgen .pah-lg-stats{font-size:14px;color:var(--mu);margin:6px 0}
.pah-llmsgen ul.pah-lg-msgs{list-style:none;margin:8px 0;padding:0;font-size:14px}
.pah-llmsgen ul.pah-lg-msgs li{padding:6px 10px;border-radius:6px;margin:0 0 6px;background:#fff7ed;color:var(--wa);border:1px solid #fed7aa}
.pah-llmsgen ul.pah-lg-msgs li.ok{background:#f0fdf4;color:var(--ok);border-color:#bbf7d0}
</style>
<h2 class="pah-lg-title">llms.txt Generator</h2>
<p class="pah-lg-sub">Create a clean llms.txt file for your website. Everything runs in your browser; nothing is uploaded.</p>

<label for="pah-lg-name">Website or project name (required)</label>
<input type="text" id="pah-lg-name" placeholder="Example: Pro Articles Hub">

<label for="pah-lg-summary">Short summary</label>
<p class="pah-lg-hint">One or two sentences about what the site covers. Shown as a quote under the title.</p>
<textarea id="pah-lg-summary" placeholder="Practical guides on blogging, SEO and free website tools."></textarea>

<label for="pah-lg-details">Extra notes for AI tools (optional)</label>
<p class="pah-lg-hint">Plain text only, no headings. For example who writes the content or how often it is updated.</p>
<textarea id="pah-lg-details" placeholder="All articles are written and reviewed by our editorial team and updated regularly."></textarea>

<label for="pah-lg-links">Pages to include</label>
<p class="pah-lg-hint">One page per line: <code>URL | Title | Short description</code>. Title and description are optional. Start a group with <code>## Section name</code>. Put less important links under <code>## Optional</code>. You can also paste the contents of an XML sitemap.</p>
<textarea id="pah-lg-links" class="pah-lg-links" placeholder="## Guides
https://example.com/seo-guide/ | SEO Guide | Beginner guide to SEO
https://example.com/blog-tips/

## Optional
https://example.com/about/ | About us"></textarea>

<div class="pah-lg-opts">
<label><input type="checkbox" id="pah-lg-auto" checked> Create titles from URLs when missing</label>
<label><input type="checkbox" id="pah-lg-dedupe" checked> Remove duplicate URLs</label>
</div>

<div class="pah-lg-btns">
<button type="button" class="pah-lg-primary" id="pah-lg-gen">Generate llms.txt</button>
<button type="button" id="pah-lg-sample">Load example</button>
<button type="button" id="pah-lg-clear">Clear</button>
</div>

<div id="pah-lg-out" hidden>
<p class="pah-lg-stats" id="pah-lg-stats"></p>
<ul class="pah-lg-msgs" id="pah-lg-msgs"></ul>
<pre id="pah-lg-code"></pre>
<div class="pah-lg-btns">
<button type="button" class="pah-lg-primary" id="pah-lg-copy">Copy</button>
<button type="button" id="pah-lg-dl">Download llms.txt</button>
</div>
</div>

<script>
(function(){
  var root=document.getElementById('pah-llmsgen'); if(!root) return;
  var $=function(id){return document.getElementById(id);};
  function clean(s){return String(s||'').replace(/[\r\t]/g,' ').replace(/\s+/g,' ').trim();}
  function titleFromUrl(u){
    try{
      var p=new URL(u).pathname.replace(/\/+$/,'');
      var seg=decodeURIComponent(p.split('/').pop()||'');
      seg=seg.replace(/\.(html?|php|aspx?|md)$/i,'').replace(/[-_]+/g,' ').trim();
      if(!seg) return 'Home';
      return seg.charAt(0).toUpperCase()+seg.slice(1);
    }catch(e){return u;}
  }
  function parse(text){
    var sections=[],cur=null,msgs=[],seen={},dups=0,bad=0,hosts={};
    function section(name){cur={name:name,items:[]};sections.push(cur);}
    var locs=text.match(/<loc>\s*([^<\s]+)\s*<\/loc>/gi);
    var lines;
    if(locs&&locs.length){
      lines=locs.map(function(l){return l.replace(/<\/?loc>/gi,'').trim();});
      msgs.push(['ok','Read '+lines.length+' URLs from the sitemap. Add titles and sections for a better file.']);
    }else{ lines=text.split('\n'); }
    lines.forEach(function(raw){
      var line=raw.trim(); if(!line) return;
      var h=line.match(/^#{1,6}\s*(.+)$/);
      if(h){section(clean(h[1]));return;}
      var parts=line.split('|');
      var url=clean(parts[0]).replace(/^[-*]\s*/,'');
      var title=clean(parts[1]); var desc=clean(parts.slice(2).join('|'));
      if(!/^https?:\/\/[^\s]+\.[^\s]+/i.test(url)){bad++;return;}
      try{hosts[new URL(url).host]=1;}catch(e){}
      if($('pah-lg-dedupe').checked){ if(seen[url]){dups++;return;} seen[url]=1; }
      if(!title&&$('pah-lg-auto').checked) title=titleFromUrl(url);
      if(!title) title=url;
      if(!cur) section('Pages');
      cur.items.push({url:url,title:title,desc:desc});
    });
    if(bad) msgs.push(['wa',bad+' line(s) skipped because they are not full URLs starting with http:// or https://.']);
    if(dups) msgs.push(['wa',dups+' duplicate URL(s) removed.']);
    if(Object.keys(hosts).length>1) msgs.push(['wa','Links point to more than one domain: '+Object.keys(hosts).join(', ')+'. Check that this is intended.']);
    return {sections:sections.filter(function(s){return s.items.length;}),msgs:msgs,empty:sections.filter(function(s){return !s.items.length;}).length};
  }
  function generate(){
    var name=clean($('pah-lg-name').value), sum=clean($('pah-lg-summary').value);
    var details=$('pah-lg-details').value.trim().replace(/^#+\s*/gm,'');
    var res=parse($('pah-lg-links').value), msgs=res.msgs.slice();
    if(!name) msgs.unshift(['wa','Add a website name. It becomes the H1 title, the only required part of llms.txt.']);
    if(!sum) msgs.push(['wa','Add a short summary. It helps AI tools understand the site quickly.']);
    if(res.empty) msgs.push(['wa',res.empty+' empty section(s) left out.']);
    var count=0,descs=0;
    var out='# '+(name||'Your Website Name')+'\n\n';
    if(sum) out+='> '+sum+'\n\n';
    if(details) out+=details+'\n\n';
    var opt=null;
    res.sections.forEach(function(s){ if(/^optional$/i.test(s.name)){opt=s;return;} out+=block(s); });
    if(opt) out+=block({name:'Optional',items:opt.items});
    function block(s){
      var b='## '+s.name+'\n\n';
      s.items.forEach(function(it){count++; if(it.desc) descs++; b+='- ['+it.title.replace(/[\[\]]/g,'')+']('+it.url+')'+(it.desc?': '+it.desc:'')+'\n';});
      return b+'\n';
    }
    if(!count) msgs.push(['wa','No valid links found. Add at least one page URL.']);
    if(count&&descs<count) msgs.push(['wa',(count-descs)+' link(s) have no description. Short descriptions make the file more useful.']);
    if(count>300) msgs.push(['wa','Your file lists '+count+' links. Consider keeping only your most important pages.']);
    if(!msgs.length) msgs.push(['ok','Looks good. Upload the file as llms.txt to the root of your site, for example https://example.com/llms.txt.']);
    out=out.replace(/\n{3,}/g,'\n\n').trim()+'\n';
    $('pah-lg-code').textContent=out;
    $('pah-lg-stats').textContent=res.sections.length+' section(s), '+count+' link(s), '+out.length+' characters';
    var ul=$('pah-lg-msgs'); ul.innerHTML='';
    msgs.forEach(function(m){var li=document.createElement('li'); if(m[0]==='ok') li.className='ok'; li.textContent=m[1]; ul.appendChild(li);});
    $('pah-lg-out').hidden=false;
  }
  $('pah-lg-gen').addEventListener('click',generate);
  $('pah-lg-sample').addEventListener('click',function(){
    $('pah-lg-name').value='Example Coffee Blog';
    $('pah-lg-summary').value='Brewing guides, equipment reviews and coffee basics for home baristas.';
    $('pah-lg-details').value='Articles are written by trained baristas and updated when equipment or prices change.';
    $('pah-lg-links').value='## Brewing Guides\nhttps://example.com/pour-over-guide/ | Pour-Over Coffee Guide | Step-by-step pour-over method with ratios\nhttps://example.com/french-press/ | French Press Guide | Grind size, timing and common mistakes\n\n## Equipment\nhttps://example.com/best-grinders/ | Best Coffee Grinders | Burr vs blade grinders compared\n\n## Optional\nhttps://example.com/about/ | About Us';
    generate();
  });
  $('pah-lg-clear').addEventListener('click',function(){
    ['pah-lg-name','pah-lg-summary','pah-lg-details','pah-lg-links'].forEach(function(id){$(id).value='';});
    $('pah-lg-out').hidden=true;
  });
  $('pah-lg-copy').addEventListener('click',function(){
    var t=$('pah-lg-code').textContent, b=this;
    function done(){b.textContent='Copied';setTimeout(function(){b.textContent='Copy';},1500);}
    if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(t).then(done,fallback);}else{fallback();}
    function fallback(){var ta=document.createElement('textarea');ta.value=t;document.body.appendChild(ta);ta.select();try{document.execCommand('copy');done();}catch(e){}document.body.removeChild(ta);}
  });
  $('pah-lg-dl').addEventListener('click',function(){
    var blob=new Blob([$('pah-lg-code').textContent],{type:'text/plain;charset=utf-8'});
    var a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download='llms.txt';
    document.body.appendChild(a); a.click(); setTimeout(function(){URL.revokeObjectURL(a.href);a.remove();},500);
  });
})();
</script>
</div>
PAHHTML;
});
