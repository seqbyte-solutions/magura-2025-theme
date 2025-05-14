import React from "react";

function getPrizeImage(prize) {
  if (prize === "vacanta") {
    return <>
    <div className="won-prize-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35" >
    <path
      d="M239.01 341.86C118.48 337.48 59.32 219.14 65.89 140.25 71.87 68.58 87.81 0 197.38 0c135.87 0 258.58 116.14 262.97 181.89 3.07 46.12-111.69 163.96-221.33 159.97Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
    <path
      d="M246.5 398.24c134.2-4.88 200.07-136.64 192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15C141.57 17.62 4.94 146.94.06 220.13c-3.42 51.36 124.35 182.55 246.43 178.11Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
  </svg>
  <div class="prize-item-content">
                    <img src={campaignData.prize_img_vacanta}  alt="" />
                </div>
      </div></>;
  } else if (prize === "set magura") {
    return <>
    <div className="won-prize-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35" >
    <path
      d="M239.01 341.86C118.48 337.48 59.32 219.14 65.89 140.25 71.87 68.58 87.81 0 197.38 0c135.87 0 258.58 116.14 262.97 181.89 3.07 46.12-111.69 163.96-221.33 159.97Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
    <path
      d="M246.5 398.24c134.2-4.88 200.07-136.64 192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15C141.57 17.62 4.94 146.94.06 220.13c-3.42 51.36 124.35 182.55 246.43 178.11Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
  </svg>
  <div class="prize-item-content">
                    <img src={campaignData.prize_img_cani}  alt="" />
                </div>
      </div></>;
  } else if (prize === "rucsac visiniu") {
    return <>
      <div className="won-prize-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35" >
    <path
      d="M239.01 341.86C118.48 337.48 59.32 219.14 65.89 140.25 71.87 68.58 87.81 0 197.38 0c135.87 0 258.58 116.14 262.97 181.89 3.07 46.12-111.69 163.96-221.33 159.97Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
    <path
      d="M246.5 398.24c134.2-4.88 200.07-136.64 192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15C141.57 17.62 4.94 146.94.06 220.13c-3.42 51.36 124.35 182.55 246.43 178.11Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
  </svg>
  <div class="prize-item-content">
                    <img src={campaignData.prize_img_rucsac}  alt="" />
                </div>
      </div>
    </>;
  } else if (prize === "rucsac bej") {
    return <>
      <div className="won-prize-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35" >
    <path
      d="M239.01 341.86C118.48 337.48 59.32 219.14 65.89 140.25 71.87 68.58 87.81 0 197.38 0c135.87 0 258.58 116.14 262.97 181.89 3.07 46.12-111.69 163.96-221.33 159.97Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
    <path
      d="M246.5 398.24c134.2-4.88 200.07-136.64 192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15C141.57 17.62 4.94 146.94.06 220.13c-3.42 51.36 124.35 182.55 246.43 178.11Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
  </svg>
  <div class="prize-item-content">
                    <img src={campaignData.prize_img_rucsac}  alt="" />
                </div>
      </div>
    </>;
  } else if (prize === "rucsac model fluturi") {
    return <>
      <div className="won-prize-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35" >
    <path
      d="M239.01 341.86C118.48 337.48 59.32 219.14 65.89 140.25 71.87 68.58 87.81 0 197.38 0c135.87 0 258.58 116.14 262.97 181.89 3.07 46.12-111.69 163.96-221.33 159.97Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
    <path
      d="M246.5 398.24c134.2-4.88 200.07-136.64 192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15C141.57 17.62 4.94 146.94.06 220.13c-3.42 51.36 124.35 182.55 246.43 178.11Z"
      style={{
        fill: "#f9bac5",
        opacity: 0.45,
      }}
    />
  </svg>
  <div class="prize-item-content">
                    <img src={campaignData.prize_img_rucsac}  alt="" />
                </div>
      </div>
    </>;
  } else {
    return (
      <svg
        className="prize-loss-icon"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 512 512"
      >
        <path d="M175.9 448c-35-.1-65.5-22.6-76-54.6C67.6 356.8 48 308.7 48 256c0-114.9 93.1-208 208-208s208 93.1 208 208-93.1 208-208 208c-28.4 0-55.5-5.7-80.1-16zM0 256a256 256 0 1 0 512 0 256 256 0 1 0-512 0zm128 113c0 26 21.5 47 48 47s48-21 48-47c0-20-28.4-60.4-41.6-77.7-3.2-4.4-9.6-4.4-12.8 0-13 17.3-41.6 57.7-41.6 77.7zm128-65c-13.3 0-24 10.7-24 24s10.7 24 24 24c30.7 0 58.7 11.5 80 30.6 9.9 8.8 25 8 33.9-1.9s8-25-1.9-33.9c-29.7-26.6-69-42.8-112-42.8zm47.6-96a32 32 0 1 0 64 0 32 32 0 1 0-64 0zm-128 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z" />
      </svg>
    );
  }
}

function Prize({ prize = null }) {
  return (
    <>
      {prize !== null ? (
        <>
          <div className="prize-content">
            <h2 className="prize-title">Felicitări!</h2>
            <p className="prize-desc">
              Ești potențial câștigător al unui premiu în campania Măgura!
              Urmează pasul de validare - ținem pumnii!
            </p>
            <div className="prize-image-container">{getPrizeImage(prize)}</div>
            <h3 className="prize-name">
              Hei, se pare că norocul ți-a zâmbit! 
            </h3>
            <h3 className="prize-name">
            Ai pus mâna pe un premiu: {prize === 'vacanta' ? <>Voucher Îmbrățisează România</> : prize === "set magura" ? <>Set Măgura</> : <>Rucsac Măgura</>}!
            </h3>
            <p className="prize-desc">
              Norocul nu stă pe loc, ai grijă să-l confirmi!
              </p>
          </div>
        </>
      ) : (
        <>
          <div className="prize-content">
            <h2 className="prize-title">Norocul nu e aici azi!</h2>
            <p className="prize-desc">De data aceasta nu ai câștigat!</p>
            <p className="prize-desc">Mai încearcă și mâine.</p>
            <div className="prize-image-container">
              {getPrizeImage(prize)}
              </div>
          </div>
        </>
      )}
    </>
  );
}

export default Prize;
