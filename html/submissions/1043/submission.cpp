#include<stdio.h>
int sokq=0;
void TRY(int *a,int n,int m,int *x,int k,int *d)
{
    if(k==m)
    {
        for(int i=1;i<=m;i++)
        if(x[i]==0) printf("0 ");else for(int j=1;j<=a[x[i]];j++) printf("%d ",x[i]);
        printf("\n");
        sokq++;
        return;
    }
    if(sokq==1000) return;
    for(int t=k==0?1:0;t<=n;t++)
    if(d[t])
    {
        x[k+1]= t; d[t]--;     //tien
        TRY(a,n,m,x,k+1,d);
        d[t]++;                //lui
    }
}
int main()
{
    int L,n,B,d[105],a[105],x[105];
    scanf("%d%d",&L,&n);
    B=L;
    for(int i=1;i<=n;i++) {scanf("%d",&a[i]); B-=a[i];}
    for(int i=1;i<=n;i++) d[i]=1;
    d[0]=B;
    TRY(a,n,n+B,x,0,d);
}
