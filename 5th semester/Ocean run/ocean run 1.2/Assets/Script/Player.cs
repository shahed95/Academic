using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class Player : MonoBehaviour {
    private Rigidbody rb;
    [SerializeField]
    private float speed, jumpforce;
    private int keypressed;
    private Animator anim;
    private Vector3 initialpos;
    private int score = 0;
    private float initialspeed;
    private int gameend = 0;
    private int onground = 0;
    private float dscore = 0;
    [SerializeField]
    Text scoreUI;
    private int waittime = 0;
    private int gamestart = 0;

    // Use this for initialization
	void Start () {
        initialspeed = speed;
        anim = GetComponent<Animator>();
        rb = this.GetComponent<Rigidbody>();
        //rb.velocity = new Vector3(0f, 0f, speed);
	}

    private void ScoreUpdate()
    {
        initialpos = transform.position;
        if(gamestart==1 && gameend==0)dscore = dscore + (5f * Time.deltaTime);
        if (gamestart == 1 && gameend == 0) score = Mathf.RoundToInt(dscore);


        if (gamestart == 0) scoreUI.text = "Press 'space' to start";
        else if (gameend == 0) scoreUI.text = score.ToString();
        else scoreUI.text = "Game End, Your Score : " + score.ToString();
    }
	
	// Update is called once per frame
	void Update () {

        speed = 0f;

        if(Input.GetKey("space"))
        {
            Debug.Log("Game started");
            gamestart = 1;
            anim.Play("Running");
        }
        if(gamestart==0)
        {
            anim.Play("standing");
        }

        if(gamestart==1) speed = initialspeed;

        ScoreUpdate();

        float horizontal = Input.GetAxis("Horizontal");
        float vertical = Input.GetAxis("Vertical");

        Vector3 movement = new Vector3(horizontal * speed * Time.deltaTime*1.5f, 0, speed*Time.deltaTime);

        waittime--;
        if (waittime < 0) waittime = 0;

        if(gameend==0)rb.MovePosition(transform.position + movement);
        
        if(Input.GetKeyDown("up"))
        {
            if(waittime==0&&gameend!=1&&keypressed==0){
                
                rb.AddForce(0f,jumpforce, 0f, ForceMode.Impulse);
                anim.Play("Jumping");
                waittime = 50;
            }

            keypressed = 1;
        }
        else{
            keypressed = 0;
        } 
        
		
	}

    void OnTriggerEnter(Collider col)
    {
        GameOver();
    }


    private void GameOver()
    {
        Debug.Log("Game is over");
        speed = 0f;
        gameend = 1;
        anim.Play("standing");
    }
}
